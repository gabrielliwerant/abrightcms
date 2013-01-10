<!DOCTYPE html <?php echo $this->doctype; ?>>

<html dir="<?php echo $this->html_dir; ?>" lang="<?php echo $this->html_lang; ?>">

<head>

    <title><?php echo $this->title; ?> | <?php echo $this->title_page; ?></title>

	<?php echo $this->meta; ?>

	<?php echo $this->css; ?>
    
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
   
</head>

<body>