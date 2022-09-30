<?php
class Database
{
    private $hostName = "localhost";
    private $userName = 'root';
    private $password = 'root';
    private $databaseName = 'store';
    private $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->hostName . ";dbname=" . $this->databaseName, $this->userName, $this->password);
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function insertIntoUserTable(string $email, string $password, string $firstName, string $lastName, string $mobile, string $role)
    {
        try {
            $sql = "INSERT INTO users (email, password, first_name,last_name,mobile,role)
        VALUES ('$email', '$password', '$firstName','$lastName','$mobile','$role')";
            $this->conn->exec($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function insertIntoUserAddressTable(int $userId, string $addressLine1, string $addressLine2, string $city, string $postalCode, string $country, string $mobile)
    {
        try {
            $sql = "INSERT INTO user_address (user_id, address_line1, address_line2, city, postal_code, country,mobile)
        VALUES ($userId, '$addressLine1', '$addressLine2', '$city', '$postalCode', '$country', '$mobile')";
            $this->conn->exec($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function insertIntoProductTable(string $name, string $description, string $category, int $quantity, float $price, int $discountId = null)
    {
        try {
            $sql = "INSERT INTO product (name, description, category, quantity, price,discount_id)
        VALUES ('$name', '$description', '$category' , $quantity, $price, $discountId)";
            $this->conn->exec($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }


    function addDiscountToProduct(int $productId, int $discountId)
    {
        /*
        TODO: check if product_id is correct
        */
        try {
            $sql = "UPDATE product SET discount_id=$discountId WHERE id=$productId";
            $this->conn->exec($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }



    public function insertIntoOrderItemsTable(int $orderId, int $productId, int $quantity)
    {
        /*
        TODO: check if order_id and product_id is correct
        */
        try {
            $sql = "INSERT INTO order_items (order_id, product_id, quantity)
        VALUES ($orderId, $productId, $quantity)";
            $this->conn->exec($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function insertIntoOrderDetailsTable(int $userId, float $total, string $status)
    {
        /*
        TODO: check if user_id is correct
        */
        try {
            $sql = "INSERT INTO order_items (user_id, total, status)
        VALUES ($userId, $total, $status)";
            $this->conn->exec($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function insertIntoDiscountTable(string $name, float $discountPercent, bool $active)
    {
        /*
        TODO: check if user_id is correct
        */
        try {
            $sql = "INSERT INTO order_items (name, discount_percent	, active)
        VALUES ('$name', $discountPercent, $active)";
            $this->conn->exec($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function insertIntoCartItemsTable(int $userId, int $productId, string $quantity)
    {
        /*
        TODO: check if user_id is correct
        */
        try {
            $sql = "INSERT INTO order_items (int user_id, int product_id, int quantity)
        VALUES ($userId, $productId, $quantity)";
            $this->conn->exec($sql);
            return true;
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function showData($table)
    {

        $sql = "SELECT * FROM $table";
        $q = $this->conn->query($sql) or die("failed!");

        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $r;
        }
        return $data;
    }


    public function getById(int $id, $table)
    {

        $sql = "SELECT * FROM $table WHERE id = :id";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':id' => $id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        return $data;
    }


    public function deleteData(int $id, $table)
    {

        $sql = "DELETE FROM $table WHERE id=:id";
        $q = $this->conn->prepare($sql);
        $q->execute(array(':id' => $id));
        return true;
    }


    // by cat

    function getProductByCategory($category)
    {
        try {
            $sql = "SELECT * FROM `product` WHERE category='$category'";
            $q = $this->conn->prepare($sql);
            $q->execute();
            $data = $q->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo $e;
        }
    }

    // by price 
    function getProductByGreaterPrice($price)
    {
        try {
            $sql = "SELECT * FROM `product` WHERE price >$price";
            $q = $this->conn->prepare($sql);
            $q->execute();
            $data = $q->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo $e;
        }
    }

    function getProductByLessPrice($price)
    {
        try {
            $sql = "SELECT * FROM `product` WHERE price < $price";
            $q = $this->conn->prepare($sql);
            $q->execute();
            $data = $q->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo $e;
        }
    }

    function getProductByBetweenPrice($priceOne, $priceTwo)
    {
        try {
            $sql = "SELECT * FROM `product` WHERE price BETWEEN $priceOne AND $priceTwo";
            $q = $this->conn->prepare($sql);
            $q->execute();
            $data = $q->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo $e;
        }
    }



    function getUserOrders(int $userId)
    {
        try {
            $sql = "SELECT * FROM `order_items` INNER JOIN users ON users.id = $userId";
            $q = $this->conn->prepare($sql);
            $q->execute();
            $data = $q->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo $e;
        }

    } 
    
    function getUserCartItems(int $userId)
    {
        try {
            $sql = "SELECT * FROM `order_items` INNER JOIN users ON users.id = $userId";
            $q = $this->conn->prepare($sql);
            $q->execute();
            $data = $q->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (Exception $e) {
            echo $e;
        }

    }

}

// test case
$c = new Database();
echo "<pre>";
// $c->insertIntoUserTable("ahmad.96@gmail.com","123456","ahmad","alawneh","0787293944","admin"); // Done
// $c->insertIntoUserTable("ahmad.96@gmail.com","123456","rama","jaradat","0787293944","admin"); // Done
// $c->insertIntoUserAddressTable(3,"amman","azzarqa","abc","00962","alrusifya","0787293944"); // Done

// print_r($c->showData("users")); // Done
// print_r($c->getById(1,"users")); //Done
// print_r($c->deleteData(1,"users")); //Done, error foreign key we need to find some way to automatic delete from child table 
                                       // fix this by define the Foreign Key constraints as ON DELETE CASCADE
// print_r($c->getProductByCategory("cats")); //Done
 print_r($c->getUserOrders(2)); //Done


echo "</pre>";
