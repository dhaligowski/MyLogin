<?php

require_once "database.class.php";

class Account
{




    /*  Create a new user acccount with $username and $password.  Return the newly created users 
    account Id
    */

    public function addAccount($username, $password)
    {
        $pdo = new Database();

        $default_image = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgZmlsbD0iIzBkNmVmZCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiB3aWR0aD0iMjQiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PHBhdGggZD0iTTE2IDdDMTYgOS4yMDkxNCAxNC4yMDkxIDExIDEyIDExQzkuNzkwODYgMTEgOCA5LjIwOTE0IDggN0M4IDQuNzkwODYgOS43OTA4NiAzIDEyIDNDMTQuMjA5MSAzIDE2IDQuNzkwODYgMTYgN1oiIHN0cm9rZT0iIzBkNmVmZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2Utd2lkdGg9IjIiLz48cGF0aCBkPSJNMTIgMTRDOC4xMzQwMSAxNCA1IDE3LjEzNCA1IDIxSDE5QzE5IDE3LjEzNCAxNS44NjYgMTQgMTIgMTRaIiBzdHJva2U9IiMwZDZlZmQiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIgc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLXdpZHRoPSIyIi8+PC9zdmc+";

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO account (account_username, account_password, account_image) VALUES (:name, :password, :image)";

        $values = [':name' => $username, ':password' => $hash, ':image' => $default_image];

        try {
            $res = $pdo->getConnection()->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception("Database query error, 1");
        }

        return $pdo->getConnection()->lastInsertId();
    }


    /*
    Valatates the username

*/
    public function isUsernameValid($username)
    {
        $valid = true;

        $len = mb_strlen($username);

        if (($len < 8) || ($len > 16)) $valid = false;
        return $valid;
    }


    /*
    Valatates the password

*/
    public function isPasswordValid($password)
    {

        $valid = true;

        $len = mb_strlen($password);

        if (($len < 8) || ($len > 16)) $valid = false;
        return $valid;
    }


    /*
Returns the Id from a given username
*/
    public function getIdFromUsername($username)
    {

        $pdo = new Database();

        $id = null;

        $query = 'SELECT account_id FROM usersdb.account WHERE (account_username = :name)';
        $values = [':name' => $username];

        try {
            $res = $pdo->getConnection()->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception("Database query error, 2");
        }
        $row = $res->fetch(PDO::FETCH_ASSOC);

        if (is_array($row)) {
            $id = $row['account_id'];
        }

        return $id;
    }

    /*
Updates the account profile with thie supplied arguments
*/
    public function updateAccount($account_id, $username,  $password,  $email, $aboutMe, $image)
    {

        //global $pdo;

        $pdo = new Database();

        if ($password) {
            $query = 'UPDATE account SET account_username = :name, account_password = :password,
        account_email = :email, account_aboutme = :aboutme, account_image = :image WHERE account_id = :id';

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $values = [
                ':name' => $username, ':password' => $hash, ':email' => $email, ':aboutme' => $aboutMe,
                ':image' => $image, ':id' => $account_id
            ];
        } else {
            $query = 'UPDATE account SET account_username = :name, 
        account_email = :email, account_aboutme = :aboutme, account_image = :image WHERE account_id = :id';


            $values = [
                ':name' => $username, ':email' => $email, ':aboutme' => $aboutMe,
                ':image' => $image, ':id' => $account_id
            ];
        }

        try {
            $res = $pdo->getConnection()->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            // echo $e->getMessage();
            // throw new Exception('Database query error, 5');
            return false;
        }


        return true;
    }


    //delete account profile
    public function deleteAccount($account_id) //error checking at orgin
    {
        $pdo = new Database();

        $query = 'DELETE FROM account WHERE account_id = :id';

        $values = [':id' => $account_id];

        /* Execute the query */
        try {
            $res = $pdo->getConnection()->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            // throw new Exception('Database query error 6');
            return false;
        }
        return true;
    }


    public function login($username, $password)
    {
        //global $pdo;
        $pdo = new Database();

        $username = trim($username);
        $password = trim($password);

        $query = 'SELECT * FROM account WHERE (account_username = :name)';

        $values = [':name' => $username];

        try {
            $res = $pdo->getConnection()->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {

            throw new Exception('Database query error, 4');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        if (is_array($row)) {
            if (password_verify($password, $row['account_password'])) {
                return true;
            }
        }

        return false;
    }



    public function getAccountData($username)
    {

        //global $pdo;
        $pdo = new Database();

        $query = 'SELECT * FROM account WHERE (account_username = :name)';

        $values = [':name' => $username];

        try {
            $res = $pdo->getConnection()->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error, 4');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        return $row;
    }
}
