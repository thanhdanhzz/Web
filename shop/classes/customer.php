<?php
    $filepath = realpath(dirname(__FILE__));

    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helpers/format.php');
?>
<?php
    class customer
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function insert_customer($data){
            $name = mysqli_real_escape_string($this->db->link, $data['name']);
            $city = mysqli_real_escape_string($this->db->link, $data['city']);
            $zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
            $address = mysqli_real_escape_string($this->db->link, $data['address']);
            $country = mysqli_real_escape_string($this->db->link, $data['country']);
            $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
            $email = mysqli_real_escape_string($this->db->link, $data['email']);
            $password = mysqli_real_escape_string($this->db->link, md5($data['password']));
            if($name == "" || $city == "" || $zipcode == "" || $address == "" || $country = "" || $phone == "" || $email == "" || $password == ""){
                $alert = "<span class='error'>Field must not be empty</span>";
                return $alert;
            }else{
                $check_email = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
                $result_check = $this->db->select($check_email);
                if($result_check){
                    $alert = "<span class='error'>Email already exists</span>";
                    return $alert;
                }else{    
                    $query = "INSERT INTO tbl_customer(name, city, zipcode, address, country, phone, email, password) VALUES('$name', '$city', '$zipcode', '$address', '$country', '$phone', '$email', '$password')";
                    $result = $this->db->insert($query);
                    if($result){
                        $alert = "<span class='success'>Customer registered successfully</span>";
                        return $alert;
                    }else{
                        $alert = "<span class='error'>Customer not registered</span>";
                        return $alert;
                    }
                }
            }
        }

        public function login_customer($data){
            $email = mysqli_real_escape_string($this->db->link, $data['email']);
            $password = mysqli_real_escape_string($this->db->link, md5($data['password']));
            if($email == "" || $password == ""){
                $alert = "<span class='error'>Field must not be empty</span>";
                return $alert;
            }else{
                $query = "SELECT * FROM tbl_customer WHERE email = '$email' AND password = '$password'";
                $result = $this->db->select($query);
                if($result){
                    $value = $result->fetch_assoc();
                    Session::set("customer_login", true);
                    Session::set("customer_id", $value['id']);
                    Session::set("customer_name", $value['name']);
                    header("Location:order.php");
                }else{
                    $alert = "<span class='error'>Email or password not match</span>";
                    return $alert;
                }
            }
        }

        public function show_customer($id){
            $query = "SELECT * FROM tbl_customer WHERE id = '$id'";
            $result = $this->db->select($query);
            return $result;
        }
        public function update_customer($data, $id){
            $name = mysqli_real_escape_string($this->db->link, $data['name']);
            $zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
            $country = mysqli_real_escape_string($this->db->link, $data['country']);
            $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
            $email = mysqli_real_escape_string($this->db->link, $data['email']);
            if($name == "" || $zipcode == "" || $country == "" || $phone == "" || $email == "" ){
                $alert = "<span class='error'>Field must not be empty</span>";
                return $alert;
            }else{
                $query = "UPDATE tbl_customer SET name = '$name', zipcode = '$zipcode', country = '$country', phone = '$phone', email = '$email' WHERE id = '$id'";
                $result = $this->db->update($query);
                if($result){
                    $alert = "<span class='success'>Customer updated successfully</span>";
                    return $alert;
                }else{
                    $alert = "<span class='error'>Customer not updated</span>";
                    return $alert;
                }
            }
        }
    }
       
?>