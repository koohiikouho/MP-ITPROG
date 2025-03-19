<?php

    echo (password_hash("password", PASSWORD_BCRYPT, array("cost" => 12)) );

?>