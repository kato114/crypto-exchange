<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here

function checkhexcolor($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}

?>



.img-height-40{
    height: 40px !important;
}

.propic{
    width: 100%;
}
.text-decoration{
    text-decoration: none !important;
}
.margin-top-20{
    margin-top: 20px !important;
}
.help-block,
.error{
    color: red;
    font-weight: bold;
}


.tile {
	border-radius: 4px;
	border: 1px solid  <?php echo $color ?>;
	padding: 0;
}
.tile-title {
	background-color:  <?php echo $color ?>;
	padding: 15px;
	color: #fff;
}
.tile-body {
	padding: 0 15px;
}

.tile-title-w-btn {
	background-color:  <?php echo $color ?>;
	padding: 15px;
	color: #fff;
}
.tile .tile-footer {
	padding: 15px;
}

.app-header {
background-color:  <?php echo $color ?>;
}

.app-header__logo {
background-color:  <?php echo $color ?>;
}

a {
color: <?php echo $color ?>;
}

.app-menu__item.active, .app-menu__item:hover, .app-menu__item:focus {
border-left-color: <?php echo $color ?>;
}

.treeview.is-expanded [data-toggle='treeview'] {
border-left-color: <?php echo $color ?>;
background: #0d1214;
}

.btn-primary {
background-color: <?php echo $color ?>;
border: 2px solid <?php echo $color ?>;
}
.btn-primary:hover {
color: #FFF;
background-color: <?php echo $color ?>;
border-color: <?php echo $color ?>;
}
.btn-primary.disabled, .btn-primary:disabled {
background-color: <?php echo $color ?>;
border-color: <?php echo $color ?>;
}

.dropdown-item.active, .dropdown-item:active {
background-color: <?php echo $color ?>;
}


.form-control:focus {
border-color: <?php echo $color ?>;
}
