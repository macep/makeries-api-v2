</body>
<!-- Included JS Files --> 
<script src="/js/foundation.min.js"></script> 
<script src="/js/foundation/jquery.offcanvas.js"></script> 
<!-- <script src="/js/foundation/app.js"></script> -->
<script src="/js/style-inputs.js"></script>
<script src="/js/responsive-tables.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script src="/js/jsScrollPane/jquery.mousewheel.js"></script>
<script>
		/*
	$(function()
	{
		$('.sidebarSumenu').jScrollPane(
		{showArrows: true,
			verticalDragMinHeight: 20,
			verticalDragMaxHeight: 20}
		);
	});
	*/
	//$( "#datepicker1" ).datepicker({ minDate: -20, maxDate: "+1M +10D" });
	//$( "#datepicker2" ).datepicker({ minDate: -20, maxDate: "+1M +10D" });
</script>

</script>
<script type="text/javascript">
 
                    
                    </script>
<script>
$(document).foundation();
$(document).ready(function() {
				$('#buttonErrorAllModalClose').live("click", function() {
								$('#errorAllModal').foundation('reveal', 'close');
				});
});
</script>


<div id="errorAllModal" class="reveal-modal" data-reveal>
				<h2>Notification</h2>
				<div class="clearfix"></div><br>
				<p class="message"></p>
				<br><br>
				<center>
				<input id="buttonErrorAllModalClose" class="largeBttn" type="submit" value="OK">
				</center>
</div>

</body>
</html>
