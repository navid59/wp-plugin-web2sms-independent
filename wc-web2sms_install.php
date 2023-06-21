<?php
    /**
     * Create a table for abandoned carts.
     */

    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $web2sms_table_name = $wpdb->prefix . "web2sms_abandoned_cart"; 


    $sql_web2sms = "CREATE TABLE $web2sms_table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        sessionId varchar(50) NULL,
        userId int(5) NOT NULL,
        orderId int(5) NULL,
        userType varchar(50) NULL,
        userInfo TEXT NULL,
        cartInfo TEXT NOT NULL,
        checkoutLink varchar(255) NULL,        
        cartStatus int(2) NOT NULL,
        smsRetry int(2) NULL,
        createdAt datetime DEFAULT NULL,
        expireAt datetime DEFAULT NULL,
        updatedAt datetime DEFAULT NULL,
        PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql_web2sms );
        add_option( 'web2sms_db_version', "1.0" );
?>
