<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Please log in";
} else {
    echo "Welcome to Dolphin CRM";
}
