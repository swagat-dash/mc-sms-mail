<section class="iq-subscribe main-bg" id="newsletter">
					<div class="container">
						<div class="row justify-content-center ">
							<div class="col-lg-10 col-sm-12">
								<div class="title-box mb-5">
									<h2 class="text-white h2">@translate(Subscribe For Newsletter)</h2>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-sm-12 text-center">
								<form class="subscribe-form">
									<input type="email" name="email" id="email" class="form-control subscription-email" placeholder="Email" required>
									
									<input type="hidden" id="subscription_url" value="{{ route('new.subscription') }}">
									<a href="javascript:;" class="button subscribe-btn buttonload" class="btn-subscribe" onclick="subscribe()">
										<i class="fa fa-refresh fa-spin d-none" id="loader-spinner"></i>
										@translate(Subscribe Now)
									</a>
								</form>
								<div class="w-60">
									<small id="invalid-email" class="text-white"></small>
								</div>
								
							
							</div>
						</div>
					</div>
				</section>