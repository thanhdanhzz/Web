<?php
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
?>
<?php
    class cart
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function add_to_cart($quantity, $id){
            $quantity = $this->fm->validation($quantity);
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $id = mysqli_real_escape_string($this->db->link, $id);
            $sId = session_id();

            $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
            $result = $this->db->select($query)->fetch_assoc();

            $productName = $result['productName'];
            $price = $result['price'];
            $image = $result['image'];

            $check_cart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId = '$sId'";
            if($check_carta){
                $msg = "Product already added to cart";
                return $msg;
            }else{
                $query_insert = "INSERT INTO tbl_cart(sId, productId, productName, price, quantity, image) VALUES('$sId','$id','$productName','$price','$quantity','$image')";
                $insert_cart = $this->db->insert($query_insert);
                
                if($insert_cart){
                    header('Location: cart.php');
                }else{
                    header('Location: 404.php');
                }
            }
        }

        public function get_product_cart(){
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->select($query);
            return $result;
        }

        public function updateCart($quantity, $cartId){
            $cartId = mysqli_real_escape_string($this->db->link, $cartId);
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);

            $query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId = '$cartId'";
            $update_cart = $this->db->update($query);
            if($update_cart){
                $msg = "<span class='success' >Quantity updated successfully</span>";
                return $msg;
            }else{
                $msg = "<span class='error' >Quantity not updated</span>";
                return $msg;
            }
        }

        public function del_cart($cartId){
            $cartId = mysqli_real_escape_string($this->db->link, $cartId);
            $query = "DELETE FROM tbl_cart WHERE cartId = '$cartId'";
            $del_cart = $this->db->delete($query);
            if($del_cart){
                header('Location: cart.php');
            }else{
                $msg = "<span class='error' >Product deleted not successfully</span>";
                return $msg;
            }
        }

        public function check_cart(){
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->select($query);
            return $result;
        }

        public function del_all_data_cart(){
            $sId = session_id();
            $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->delete($query);
            return $result;
        }

        public function insertOrder($customer_id){
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $get_product = $this->db->select($query);
            if($result){
                while($result = $get_product->fetch_assoc()){
                    $productId = $result['productId'];
                    $productName = $result['productName'];
                    $quantity = $result['quantity'];
                    $price = $result['price'] * $quantity;
                    $image = $result['image'];
                    $customer_id = $customer_id;

                    $query_insert = "INSERT INTO tbl_order(productId, productName, quantity, price, image, customer_id)
                     VALUES('$productId','$productName','$quantity','$price','$image','$customer_id')";
                    $insert_order = $this->db->insert($query_insert);
            }
        }
        
    }
}

?>