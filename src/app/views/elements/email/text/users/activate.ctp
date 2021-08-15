Hi <?php echo $data['User']['first_name'];?>,

In order to access your account and more features of our website, please
follow the link below to activate your account:

<?php echo $data['User']['activate_link'];?>

For your records, your login details are:
Username: <?php echo $data['User']['username'];?>

Password: <?php echo $data['User']['password'];?>


Enjoy the services!

Thank You
<?php echo $appConfigurations['name'];?>

If you never registered at our website, please contact the administrator
by submitting the form on our contact page.
