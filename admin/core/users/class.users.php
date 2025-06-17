<?php
class Users extends dbClass {

    protected $session;

    public function __construct() {
        parent::__construct();
        $this->session = isset($_SESSION['admin']) ? $_SESSION['admin'] : false;
        $this->is_logged();
    }

    public function get()
    {
        $id = intval($this->session);
        if($id){
            $q = $this->q("SELECT * FROM users WHERE id = '$id' LIMIT 1");
            if($this->numrows($q) > 0){
                return $this->object($q);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function is_logged(){
        if (empty($this->session)) {
            header("Location: login.php");
            exit();
        }
    }
}
$users = new Users();
$userData = $users->get();
if(!$userData){
    header("Location: login.php");
    exit();
}
?>