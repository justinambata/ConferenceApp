<?php
	$Settings = $this->session->userdata('Settings');
	
	$AuthorDivision = "";
	foreach($Settings as $setting){
		if($setting['Property'] == "AuthorDivision"){
			$AuthorDivision = $setting['Value'];
		}
	}
?>
		</div>
		<div class="footer">
			<div class="container">
				<table width="100%">
					<tr>
						<td align="left">
							<p class="text-muted">
								<?php echo $AuthorDivision; ?> &copy; 2013
							</p>
						</td>
						<td align="right">
							<p class="text-muted">
								<a href="<?php echo base_url()."index.php/app/help";?>">Help</a>
								&middot;
								<a href="<?php echo base_url()."index.php/app/about";?>">About</a>
								&middot;
								<a href="<?php echo base_url()."index.php/app/contactus";?>">Contact Us</a>
							</p>
						</td>
					</tr>
				</table>
			</div>
		</div>
		
		<!-- CodeIgniter
		================================================== -->
		<script type="text/javascript">
			if(!NREUMQ.f){NREUMQ.f=function(){NREUMQ.push(["load",new Date().getTime()]);var e=document.createElement("script");e.type="text/javascript";e.src=(("http:"===document.location.protocol)?"http:":"https:")+"//"+"js-agent.newrelic.com/nr-100.js";document.body.appendChild(e);if(NREUMQ.a)NREUMQ.a();};NREUMQ.a=window.onload;window.onload=NREUMQ.f;};NREUMQ.push(["nrfj","beacon-5.newrelic.com","eb488e72a1","3758250","NgEEZBYHDUFWVk0KWg9LJUUXEgxfGFZWB1AIAwhZEAMRHR0=",0,123,new Date().getTime(),"","","","",""]);
		</script>
		
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<!-- Layer8 version 2.0.0.107 -->
		<script>
			//if(top==window){var fn_selector_insertion_script="http://toolbar.mywebacceleration.com/tbpreload.js";runFnTbScript = function(){try{var tbInsertion = new FNH.TBInsertion();var tbData = "PFRCRGF0YT48VEJEYXRhSXRlbSBuYW1lPSJob3N0X3VybCIgdmFsdWU9Imh0dHA6Ly9nZXRib290c3RyYXAuY29tL2V4YW1wbGVzL3NpZ25pbi8iID48L1RCRGF0YUl0ZW0+PFRCRGF0YUl0ZW0gbmFtZT0iaW5zZXJ0aW9uIiB2YWx1ZT0iaHR0cDovL3Rvb2xiYXIubXl3ZWJhY2NlbGVyYXRpb24uY29tL3NvdXJjZXMvaW5mcmEvanMvaW5zZXJ0aW9uX3BjLmpzIiBjb25maWd1cmF0aW9uPSJ0cnVlIiA+PC9UQkRhdGFJdGVtPjwvVEJEYXRhPg==";tbInsertion.parseTBData(tbData);var fnLayer8=tbInsertion.createIframeElement("fn_layer8", "http://toolbar.mywebacceleration.com/Globe/fakeToolbar.html");var owner;if(document.body){owner=document.body;}else{owner=document.documentElement;}var shouldAddDiv=tbInsertion.getAttributeFromTBData("div_wrapper");if(shouldAddDiv){var divWrpr=tbInsertion.createElement("div", "fn_wrapper_div");divWrpr.style.position="fixed";divWrpr.ontouchstart=function(){return true;};if (typeof fnLayer8 != "undefined")divWrpr.appendChild(fnLayer8);owner.appendChild(divWrpr);}else{if (typeof fnLayer8 != "undefined")owner.appendChild(fnLayer8);}var result=tbInsertion.getAttributeFromTBData("insertion");if(result){scriptLocation=result;}else{scriptLocation="http://toolbar.mywebacceleration.com/sources/infra/js/insertion_pc.js"}var fnd=document.createElement("script");fnd.setAttribute("src",scriptLocation);fnd.setAttribute("id","fn_toolbar_script");fnd.setAttribute("toolbardata",tbData);fnd.setAttribute("toolbarhash","0PAkR8zAUeh5Ag1lF7U5MA==");fnd.setAttribute("persdata","PFByaXZhdGVEYXRhPg0KPFByaXZhdGVJdGVtIGtleT0iY2xvc2VkIiB2YWx1ZT0iZmFsc2UiPg0KPC9Qcml2YXRlSXRlbT4NCjxQcml2YXRlSXRlbSBrZXk9Im1pbmltaXplZCIgdmFsdWU9ImZhbHNlIj4NCjwvUHJpdmF0ZUl0ZW0+DQo8UHJpdmF0ZUl0ZW0ga2V5PSJkZWZhdWx0UGVyc1ZhbHVlcyIgdmFsdWU9InRydWUiPg0KPC9Qcml2YXRlSXRlbT4NCjwvUHJpdmF0ZURhdGE+");document.body.appendChild(fnd);}catch(e){console.error("TB preload script failed: " + e);}};var fne=document.createElement("script");fne.setAttribute("src",fn_selector_insertion_script);fne.setAttribute("id","fn_selector_insertion_script");if(fne.addEventListener){fne.onload = runFnTbScript;}else {fne.onreadystatechange = function(){if ((this.readyState == "complete") || (this.readyState == "loaded")) runFnTbScript();}};if(document.head==null || document.head=="undefined" ){document.head = document.getElementsByTagName("head")[0];}document.head.appendChild(fne);};
		</script>
		<script src="<?php echo base_url()."jquery/jquery-1.11.1.min.js";?>"></script>
		<script src="<?php echo base_url()."bootstrap/js/bootstrap.min.js";?>"></script>
		<script src="<?php echo base_url()."bootstrap/js/holder.js";?>"></script>
		<script src="<?php echo base_url()."bootstrap/js/offcanvas.js";?>"></script>
		<script src="<?php echo base_url()."AngularJS/angular-1.2.20.min.js";?>"></script>
		<script src="<?php echo base_url()."AngularJS/angular-1.3.0.min.js";?>"></script>
	</body>
</html>