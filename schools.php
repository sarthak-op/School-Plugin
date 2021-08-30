<?php
    /*
    Plugin Name: Schools Final
    Description: Schools Info.
    Version: 1.0.0
    Author: Sarthak  
    License: GPL2
    */
    register_activation_hook( __FILE__, 'School_Data');
    register_deactivation_hook( __FILE__, 'School_Data');
    function School_Data() {
      global $wpdb;
      $charset_collate = $wpdb->get_charset_collate();
      $table_name = $wpdb->prefix . 'schoolfinal';
      $sql = "CREATE TABLE `$table_name` (
      `user_id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(220) DEFAULT NULL,
      `pan` varchar(220) DEFAULT NULL,
      `address` varchar(220) DEFAULT NULL,
      `city` varchar(220) DEFAULT NULL,
      `state` varchar(220) DEFAULT NULL,
      `phone` varchar(220) DEFAULT NULL,
      `email` varchar(220) DEFAULT NULL,
     
      PRIMARY KEY(user_id)
      ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
      ";
      if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
      }
    }
    add_action('admin_menu', 'addAdminPageContent');
    function addAdminPageContent() {
      add_options_page('SCHOOL', 'SCHOOL', 'manage_options' ,__FILE__, 'schoolsPage', 'dashicons-wordpress');
    }
    function schoolsPage() {
      global $wpdb;
      $table_name = $wpdb->prefix . 'schoolfinal';
      if (isset($_POST['newsubmit'])) {
        $name = $_POST['newname'];
        $pan = $_POST['newpan'];
        $address = $_POST['newaddress'];
        $city = $_POST['newcity'];
        $state = $_POST['newstate'];
        $phone = $_POST['newphone'];
        $email = $_POST['newemail'];
        $wpdb->query("INSERT INTO $table_name(name,pan,address,city,state,phone,email) VALUES('$name','$pan','$address','$city','$state','$phone','$email')");
        echo "<script>location.replace('options-general.php?page=schools%2Fschools.php');</script>";
      }
      if (isset($_POST['uptsubmit'])) {
        $id = $_POST['uptid'];
        $name = $_POST['uptname'];
        $pan =$_POST['uptpan'];
        $address = $_POST['uptaddress'];
        $city = $_POST['uptcity'];
        $state = $_POST['uptstate'];
        $phone = $_POST['uptphone'];
        $email = $_POST['uptemail'];
        $wpdb->query("UPDATE $table_name SET name='$name',pan='$pan',address='$address',city='$city',state='$state',phone='$phone',email='$email' WHERE user_id='$id'");
        echo "<script>location.replace('options-general.php?page=schools%2Fschools.php');</script>";
      }
      if (isset($_GET['del'])) {
        $del_id = $_GET['del'];
        $wpdb->query("DELETE FROM $table_name WHERE user_id='$del_id'");
        echo "<script>location.replace('options-general.php?page=schools%2Fschools.php');</script>";
      }
      ?>
      <div class="wrap">
        <h2>School Details</h2>
        <table class="wp-list-table widefat striped">
          <thead>
            <tr>
              <th width="25%">User ID</th>
              <th width="25%">School Name</th>
              <th width="25%">School Pan</th>
              <th width="25%">School Address</th>
              <th width="25%">City</th>
              <th width="25%">State</th>
              <th width="25%">Phone No</th>
              <th width="25%">E-Mail</th>
              <th width="25%">Actions</th>
            </tr>
          </thead>
          <tbody>
            <form action="" method="post">
              <tr>
                <td><input type="text" value="AUTO_GENERATED" disabled></td>
                <td><input type="text" id="newname" name="newname"></td>
                <td><input type="text" id="newpan" name="newpan"></td>
                <td><input type="text" id="newaddress" name="newaddress"></td>
                <td><input type="text" id="newcity" name="newcity"></td>
                <td><input type="text" id="newstate" name="newstate"></td>
                <td><input type="text" id="newphone" name="newphone"></td>
                <td><input type="text" id="newemail" name="newemail"></td>
                <td><button id="newsubmit" name="newsubmit" type="submit">INSERT</button></td>
              </tr>
            </form>
            <?php
              $result = $wpdb->get_results("SELECT * FROM $table_name");
              foreach ($result as $print) {
                echo "
                  <tr>
                    <td width='25%'>$print->user_id</td>
                    <td width='25%'>$print->name</td>
                    <td width='25%'>$print->pan</td>
                    <td width='25%'>$print->address</td>
                    <td width='25%'>$print->city</td>
                    <td width='25%'>$print->state</td>
                    <td width='25%'>$print->phone</td>
                    <td width='25%'>$print->email</td>
                    <td width='25%'><a href='options-general.php?page=schools%2Fschools.php&upt=$print->user_id'><button type='button'>UPDATE</button></a> <a href='options-general.php?page=schools%2Fschools.php&del=$print->user_id'><button type='button'>DELETE</button></a></td>
                  </tr>
                ";
              }
            ?>
          </tbody>  
        </table>
        <br>
        <br>
        <?php
          if (isset($_GET['upt'])) {
            $upt_id = $_GET['upt'];
            $result = $wpdb->get_results("SELECT * FROM $table_name WHERE user_id='$upt_id'");
            foreach($result as $print) {
              $name = $print->name;
              $pan = $print->pan;
              $address = $print->address;
              $city = $print->city;
              $state = $print->state;
              $phone = $print->phone;
              $email = $print->email;
            }
            echo "
            <table class='wp-list-table widefat striped'>
              <thead>
                <tr>
                  <th width='25%'>User ID</th>
                  <th width='25%'>Name</th>
                  <th width='25%'>School PAN</th>
                  <th width='25%'>Address</th>
                  <th width='25%'>City</th>
                  <th width='25%'>State</th>
                  <th width='25%'>Phone</th>
                  <th width='25%'>Email Address</th>
                  <th width='25%'>Actions</th>
                </tr>
              </thead>
              <tbody>
                <form action='' method='post'>
                  <tr>
                    <td width='25%'>$print->user_id <input type='hidden' id='uptid' name='uptid' value='$print->user_id'></td>
                    <td width='25%'><input type='text' id='uptname' name='uptname' value='$print->name'></td>
                    <td width='25%'><input type='text' id='uptpan' name='uptpan' value='$print->pan'></td>
                    <td width='25%'><input type='text' id='uptaddress' name='uptaddress' value='$print->address'></td>
                    <td width='25%'><input type='text' id='uptcity' name='uptcity' value='$print->city'></td>
                    <td width='25%'><input type='text' id='uptstate' name='uptstate' value='$print->state'></td>
                    <td width='25%'><input type='text' id='uptphone' name='uptphone' value='$print->phone'></td>
                    <td width='25%'><input type='text' id='uptemail' name='uptemail' value='$print->email'></td>
                    <td width='25%'><button id='uptsubmit' name='uptsubmit' type='submit'>UPDATE</button> <a href='options-general.php?page=schools%2Fschools.php'><button type='button'>CANCEL</button></a></td>
                  </tr>
                </form>
              </tbody>
            </table>";
          }
        ?>
      </div>
      <?php
    }

    //shortcode for table
    add_shortcode('test','schoolsPage' );
    //shortcode
    add_shortcode('test2','data1');
    function data1($atts, $content = null, $tag = '' ){
      
      global $wpdb;
      $results = $wpdb->get_results("SELECT * FROM wp_schoolfinal ");
      
      $content ="";
      $content .= "<table><thead><tr>SCHOOLS:-</tr></thead></table>";
      foreach($results as $result){
        $content .= "<tr><td>". $result -> name . "</td></tr><br>";
        $content .= "<tr><td>". $result -> pan . "</td></tr><br>";
        $content .= "<tr><td>". $result -> address. "</td></tr><br>";
        $content .= "<tr><td>". $result -> city. "</td></tr><br>";
        $content .= "<tr><td>". $result -> state. "</td></tr><br>";
        $content .= "<tr><td>". $result -> phone . "</td></tr><br>";
        $content .= "<tr><td>". $result -> email . "</td></tr><br><br>";      
      }
      wp_enqueue_style( 'style', plugins_url( '/css/style.css', __FILE__ ) );
      $a = shortcode_atts( array(
        'class' => 'container',
    
      
    ), $atts );

    return '<a class="' . esc_attr($a['class']) . '">' . $content . '</a>';
      
      
      return $content;

}