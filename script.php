<?php

    # Pull mock user data
    function load_users() {
        # pull JSON data from mock API
        $json_data = file_get_contents('https://jsonplaceholder.typicode.com/users');
        $users = json_decode($json_data, true); # true: returns associative array

        return $users;
    }
    
    # add new user to user directory
    function create_user($new_user) { 
        # Initialise $users as an empty array
        $users = $_SESSION['users'];     

        # Add the new user to existing user directory
        $users[] = $new_user;
        
        # Assign $users to superglobal session variable
        $_SESSION['users'] = $users;
    }

?>