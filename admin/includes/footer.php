</div>
<!--footer-->
<div id="footer1" class="col-md-12 text-center">&copy; copyright 2017-2018 New looks</span></div>
<!--footer end-->
<script>
function updateSizes(){
	var sizeString = '';
	for(var i=1; i<=12;i++){
		if (jQuery('#size'+i).val() !='') {
			sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
		}
	}
	jQuery('#sizes').val(sizeString);
}

	function get_child_options(selected) {
		if (selected === 'undefined') {
			var selected='';
		}
		var parentID = jQuery('#parent').val();
		jQuery.ajax({
			url: '/ecommerce/admin/parsers/child_category.php',
			type: 'POST',
			data: {parentID : parentID, selected : selected},
			success: function(data){
				jQuery('#child').html(data);
			},
			error: function(){alert ("Something went wrong with the child options")},
		});
	}
	jQuery('select[name="parent"]').change(function () {
		get_child_options();
	});

</script>

</body>
</html>