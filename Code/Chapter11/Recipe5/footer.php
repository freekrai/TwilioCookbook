		</div>
	</div>
<!-- Modal -->
<div class="modal fade" id="myModal">
	<div class="modal-dialog">
		<form method="post" action="send.php">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Share Photo</h4>
			</div>
			<div class="modal-body">
				<center>
					<img src="" id="mimg" class="img-thumbnail"/>
					<br /><br />
					<fieldset>
						<div class="form-group">
							<input type="tel" class="form-control" id="exampleInputEmail" name="phone" placeholder="Enter phone number">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="exampleInputEmail" name="message" placeholder="Message">
						</div>
					</fieldset>
					<input type="hidden" value="" name="himg" id="himg" />
				</center>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Share Photo</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>