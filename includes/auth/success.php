<?php
/**
 * Yeah, this is kinda weird to immediately close the window on load,
 * but because WordPress opened the oAuth window, WordPress needs to close it
 * on successful authentication
 *
 * @package Headline Studio
 */

ob_start();
?>
<script type="text/javascript">
	window.close();
</script>
<?php
ob_end_flush();
