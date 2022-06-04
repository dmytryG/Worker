<?php

include_once 'utils/Constants.php';
include_once 'utils/logger.php';
include_once 'entity/User.php';
include_once 'entity/Task.php';

class MySQL {
    private $connection;


    public function __construct()
    {
        global $DATABASE_HOST, $DATABASE_PORT, $DATABASE_NAME, $DATABASE_PASSWORD, $DATABASE_USER;
        $dsn = "mysql:dbname=".$DATABASE_NAME.";host=".$DATABASE_HOST;
        $this->connection = new PDO($dsn, $DATABASE_USER, $DATABASE_PASSWORD);
    }

    public function __toString()
    {
        return "Database";
    }

    public function create_tables(): void {
        $statement = file_get_contents("res/tables.sql");
        echo "Statement to be executed: " . $statement;
        if($statement) {
            $res = $this->connection->exec($statement);
            if($res) {
                my_log("DB successfully created");
            } else {
                var_dump($this->connection->errorInfo());
                my_log("DB error: " . var_dump($res));
            }
        } else {
            my_log("Error during reading DB file!");
        }
    }

    public function create_user_raw($login, $status): void { // login, status_name
        $statusIndex = $this->connection->prepare("select id from user_status where status = ?");
        $is_ok = $statusIndex->execute(array($status));
        $statusIndex = $statusIndex->fetch(PDO::FETCH_ASSOC);
        if(!$is_ok || !$statusIndex) {
            throw new Exception("Failed to get id of the status");
        }
        $statusIndex = $statusIndex["id"];

        my_log("Get user_status index for " . $status . ": " . $statusIndex);

        $statement = $this->connection->prepare("Insert into `users` (login, status_id) values (? , ?);");
        $is_ok = $statement->execute(array($login, $statusIndex));
        if(!$is_ok) {
            throw new Exception("Failed to create user");
        }

        my_log("User successfully created");
    }

    public function create_user(User $user) {
        $this->create_user_raw($user->getUsername(), $user->getStatus());
    }

    public function login($login, $password): User {
        $user = $this->connection->prepare("select * from users where login = ?;");
        $user->execute(array($login));
        $cur_user = $user->fetch(PDO::FETCH_ASSOC);
        my_log("Trying to get user: " . var_export($cur_user, true));
        if ($user->rowCount() > 0 && isset($cur_user["id"])) {
            $new_user = new User($cur_user["id"], $cur_user["login"], $cur_user["status_id"]);
        } else {
            throw new Exception("User not found");
        }

        $status = $this->connection->prepare("select * from user_status where id = ?;");
        $is_ok = $status->execute(array($new_user->getStatus()));
        $status_name = $status->fetch(PDO::FETCH_ASSOC);
        if($is_ok && isset($status_name["id"])) {
            $new_user->setStatus($status_name["id"]);
        } else {
            throw new Exception('Status not found');
        }

        return $new_user;
    }

    public function create_task_raw($emloyee_id, $employer_id, $header, $content) {
        $query = $this->connection->prepare("insert into task (employee_id, employer_id, status_id, header, description) values (?, ?, ?, ?, ?);");
        $is_ok = $query->execute(array($emloyee_id, $employer_id, 1, $header, $content));
        if ($is_ok) {
            return $this->connection->lastInsertId();
        } else {
            throw new Exception("Can't add new task");
        }
    }

    public function create_task(Task $task): Task {
        $id = $this->create_task_raw($task->getEmployeeId(), $task->getEmployerId(), $task->getHeader(), $task->getDescription());
        $task->setId($id);
        return $task;
    }

    public function get_task($id): Task {
        $query = $this->connection->prepare("SELECT * FROM task where id = ?;");
        $is_ok = $query->execute(array($id));
        $task = $query->fetch(PDO::FETCH_ASSOC);
        if ($is_ok && isset($task["id"])) {
            return new Task($task["id"], $task["employee_id"], $task["employer_id"], $task["header"], $task["description"], $task["datetime"], $task["status"]);
        } else {
            throw new Exception("Task not found");
        }
    }

    /**
     * @return array
     * @throws Exception
     */
    public function get_all_users(): array
    {
        $query = $this->connection->prepare("SELECT * FROM users");
        $is_ok = $query->execute();
        if($is_ok) {
            $users = $query->fetchAll(PDO::FETCH_ASSOC);
            $user_arr = array();
            foreach ($users as $user) {
                my_log("User: " . var_export($user, true));
                $user_arr[] = new User($user["id"], $user["login"], $user["status_id"]);
            }

            return $user_arr;
        } else {
            throw new Exception("Cannot get all users in DB");
        }
    }

    /**
     * @param $users
     * @return array
     * @throws Exception
     */
    public function set_user_statuses(array $users):array {
        $query = $this->connection->prepare("SELECT * FROM user_status");
        $is_ok = $query->execute();
        if($is_ok) {
            $statuses = $query->fetchAll(PDO::FETCH_ASSOC);
            $statuses_arr = array();
            foreach ($statuses as $status) {
                $statuses_arr[$status["id"]] = $status["status"];
            }
            foreach ($users as $user) {
                $user->setStatus($statuses_arr[$user->getStatus()]);
            }
            return $users;
        } else {
            throw new Exception("Fail to load user statuses");
        }
    }

    public function get_user_status($user_login) {
        $query = $this->connection->prepare("SELECT * FROM user_status right join users 
        on users.status_id = user_status.id where login = ?;");

        $is_ok = $query->execute(array($user_login));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($is_ok && isset($result["id"])) {
            return $result["status"];
        } else {
            throw new Exception("Can't get user status");
        }
    }

    public function get_user($user_login): User {
        $query = $this->connection->prepare("SELECT * FROM user_status right join users 
        on users.status_id = user_status.id where login = ?;");

        $is_ok = $query->execute(array($user_login));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if($is_ok && isset($result["id"])) {
            return new User($result["id"], $result["login"], $result["status"]);
            //$result["status"];
        } else {
            throw new Exception("Can't get user status");
        }
    }

    public function get_tasks(User $user): array {
        global $EMPLOYEE_USER_STATUS, $EMPLOYER_USER_STATUS;
        if (is_numeric($user->getStatus())) {
            $user->setStatus($this->get_user_status($user->getUsername()));
        }
        if ($user->getStatus() == $EMPLOYEE_USER_STATUS) {
            $query = $this->connection->prepare("SELECT task.id, task.employee_id, task.employer_id, task.header, task.description, 
                task.datetime, task_status.status  FROM task inner join task_status on task.status_id = task_status.id left join users 
                on users.id = task.employee_id where users.login = ? order by datetime desc;");
            my_log("User is employee");
        }
        else if ($user->getStatus() == $EMPLOYER_USER_STATUS) {
            $query = $this->connection->prepare("SELECT task.id, task.employee_id, task.employer_id, task.header, task.description, 
                task.datetime, task_status.status  FROM task inner join task_status on task.status_id = task_status.id left join users 
                on users.id = task.employer_id where users.login = ? order by datetime desc;");
            my_log("User is employer");
        }
        else {
            throw new Exception("Invalid user status: " . $user->getStatus());
        }
        $is_ok = $query->execute(array($user->getUsername()));

        if($is_ok) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $tasks = array();
            foreach ($result as $task) {
                if(isset($task["id"])) {
                    $tasks[] = new Task($task["id"], $task["employee_id"]
                        , $task["employer_id"], $task["header"], $task["description"],
                        $task["datetime"], $task["status"]);
                }
            }
            return $tasks;
        }
        else {
            throw new Exception("Can't get user's projects");
        }
    }

    public function get_users_by_status(String $status) {
        global $EMPLOYEE_USER_STATUS;
        $query = $this->connection->prepare("select users.id, users.login, user_status.status
            from users left join user_status on user_status.id = 
            users.status_id where user_status.status = ?;");
        $is_ok = $query->execute(array($status));
        if($is_ok) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $users = array();
            foreach ($result as $user) {
                $users[] = new User($user["id"], $user["login"], $user["status"]);
            }
        } else {
            throw new Exception("Can't get users");
        }
        return $users;
    }

    public function get_task_with_status($id): Task {
        $query = $this->connection->prepare("select task.id, task.employee_id, 
        task.employer_id, task.header, task.description, task.datetime, task_status.status 
        from task left join task_status on task.status_id = task_status.id where task.id = ?;");
        $is_ok = $query->execute(array($id));
        $task = $query->fetch(PDO::FETCH_ASSOC);
        if ($is_ok && isset($task["id"])) {
            return new Task($task["id"], $task["employee_id"], $task["employer_id"], $task["header"], $task["description"], $task["datetime"], $task["status"]);
        } else {
            throw new Exception("Task not found");
        }
    }

    public function get_reports($task_id) {

        include_once 'entity/Report.php';

        $query = $this->connection->prepare("select * from reports where task_id = ?;");
        $is_ok = $query->execute(array($task_id));
        $reports = $query->fetchAll(PDO::FETCH_ASSOC);
        $res = array();
        if ($is_ok) {
            foreach ($reports as $report) {
                $res[] = new Report($report["id"], $report["task_id"], $report["filename"], $report["date"]);
            }
            return $res;
        } else {
            throw new Exception("Reports not found");
        }
    }

    public function get_comments_for_report($task_id) {

        include_once 'entity/Comment.php';

        $query = $this->connection->prepare("select * from comments where report_id = ?;");
        $is_ok = $query->execute(array($task_id));
        $comments = $query->fetchAll(PDO::FETCH_ASSOC);
        $res = array();
        if ($is_ok) {
            foreach ($comments as $comment) {
                $res[] = new Comment($comment["id"], $comment["report_id"],
                    $comment["task_id"], $comment["message"]);
            }
            return $res;
        } else {
            throw new Exception("Comments not found");
        }
    }

    public function add_comment_raw($task_id, $report_id, $content) {
        $query = $this->connection->prepare("insert into comments (report_id, task_id, message) values (?, ?, ?);");
        $is_ok = $query->execute(array($report_id, $task_id, $content));
        if (!$is_ok) {
            throw new Exception("Cannot add comment");
        }
    }

    public function add_report_raw($task_id, $filenmae) {
        $query = $this->connection->prepare("insert into reports (task_id, filename) value (?, ?);");
        $is_ok = $query->execute(array($task_id, $filenmae));
        if (!$is_ok) {
            throw new Exception("Cannot add report");
        }
    }

    public function set_task_status($task_id, $status_name) {
        $query = $this->connection->prepare("update task set status_id = 
            (select id from task_status where status = ?) 
            where id = ?;");
        $is_ok = $query->execute(array($status_name, $task_id));
        if (!$is_ok) {
            throw new Exception("Cannot update status");
        }
    }

}

?>