<?php include('view-header.php'); ?>

<h2>Export closed picklists to CSV</h2>
<form method="post" action="app.php?step=export">
    <p>
        <label for="sincedate">Order reference for all orders</label><br/>
        <input type="text" name="sincedate" id="sincedate" value="<?php echo date('Y-m-d', strtotime('-1day')) ?>">
    </p>
    <p>
        <label for="startid">From which picklist ID do we want to export? (optional)</label><br/>
        <input type="text" name="startid" id="startid" value="">
    </p>
    <p>
        <label for="endid">To which picklist ID do we want to export? (optional)</label><br/>
        <input type="text" name="endid" id="endid" value="">
    </p>
    <p><input type="submit" value="Export"></p>
</form>

<?php include('view-footer.php'); ?>
