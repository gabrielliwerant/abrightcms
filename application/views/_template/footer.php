<?php if ( ! defined('DENY_ACCESS')) exit('403: No direct file access allowed'); ?>

</div> <!-- End the inner wrapper to make footer 100% screen width -->

<footer>
	<nav>
		<ul>
			<?php echo $this->footer_nav; ?>
		</ul>
	</nav>	
	
	<div id="fine-print">
		<ul>
			<?php echo $this->fine_print; ?>
		</ul>
	</div>
</footer>

</div> <!-- End outer wrapper here -->

<?php echo $this->footer_js; ?>

</body>

</html>