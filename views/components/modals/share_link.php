<div class="modal fade" id="modal_share_link" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered mw-650px">
		<div class="modal-content" id="share_general">
			
			<div class="modal-header pb-0 border-0 justify-content-end">
				<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
					<?= $svg_exiticon; ?>
				</div>
			</div>
			
			<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
				<div class="text-center mb-13">
					<h1 class="mb-3">Here's your customized link!</h1>
					<div class="text-muted fw-bold fs-5">Copy and share the link below with your customers. With this link, they can easily provide measurements and other details of the project. We will explain everything they need to know.</div>
				</div>
				<div class="">
					<div class="d-flex">
						<input id="copy_clipboard_input" type="text" class="form-control form-control-solid me-3 flex-grow-1" name="copy_clipboard" value="<?= $customer_link.$loguserid; ?>" />
						<button id="copy_clipboard_btn" class="btn btn-light btn-active-light-primary fw-bolder flex-shrink-0" data-clipboard-target="#copy_clipboard_input" onClick="copyToClipboard()">Copy Link</button>
					</div>
					<!-- <p class="fs-6 text-gray-600 py-4 m-0">Did you know you can earn rewards when you have more customers? <a href="#">Find out more</a></p> -->
				</div>
				<br/>
				<hr style="color:#ccc"/>
				<p class="fs-6 text-gray-600 py-4 m-0">Or select an option below to share the link directly </p>
				<div class="d-flex">
					<a onClick="shareLinks('whatsapp')" class="btn btn-light w-100"><i class="lab la-whatsapp text-success fs-1"></i> Whatsapp</a>
					<a onClick="shareLinks('facebook')" class="btn btn-light w-100 mx-6"><i class="lab la-facebook text-primary fs-1"></i> Facebook</a>
					<a onClick="shareLinks('twitter')" class="btn btn-light w-100"><i class="lab la-twitter text-primary fs-1"></i> Twitter</a>
				</div>
			</div>
			
		</div>
		
	</div>
</div>

<script>
	function shareLinks(media){
		//var message = document.getElementById("messageBlock").textContent;
		var message = 'Hi, help your tailor by providing your measurements through this link - <?= $customer_link.$loguserid; ?>';

		shareLink(media, message);
	}
</script>