<!DOCTYPE html <?php echo $this->doctype; ?>>

<html dir="<?php echo $this->html_dir; ?>" lang="<?php echo $this->html_lang; ?>">

<head>

    <title><?php echo $this->title; ?> | <?php echo $this->title_page; ?></title>

	<?php echo $this->meta; ?>

	<?php echo $this->css; ?>
	
	<?php echo $this->favicon; ?>
	
	<?php echo $this->head_js; ?>
   
</head>

<body>
	
<div id="wrapper-outer" class="<?php echo $this->page; ?>">
	
	<div id="wrapper-inner">