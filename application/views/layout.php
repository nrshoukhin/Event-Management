<?php
$viewWithoutHeaderAndFooter = ["attendee/register","errors/404","auth/login","auth/register"];
if( !in_array($view, $viewWithoutHeaderAndFooter) ){
	include 'partials/header.php';
}
?>
<?php echo $content; ?>
<script type="text/javascript">
var baseUrl = "<?= BASE_URL ?>";
</script>
<?php
if( !in_array($view, $viewWithoutHeaderAndFooter) ){
	include 'partials/footer.php';
}
?>
<?php if($view === "dashboard"): ?>
<script type="text/javascript">
var adminCheck = <?= $_SESSION['is_admin'] ?>;
</script>
<!-- load dashboard js -->
<script src="<?php echo BASE_URL; ?>assets/js/dashboard.js?v=<?= time() ?>"></script>
<!-- end load dashboard js -->
<?php elseif($view === "search/searchResults"): ?>
<script type="text/javascript">
var queryString = "<?= htmlspecialchars($_GET['query'] ?? '') ?>";
</script>
<script src="<?php echo BASE_URL; ?>assets/js/search.js?v=<?= time() ?>"></script>
<?php endif; ?>