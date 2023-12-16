<div class="sidebar">
                <div class="logo">
                     <img src="images/logo.jpg" class="img-fluid" alt=""/>
                </div>
                <div class="userInfo">
                	<div class="row">
                    	<div class="col-md-auto"><img src="images/user.jpg" width="57" height="60" alt=""/></div>
                        <div class="col"><h4>Good Morning, <br>
<span>Admin</span></h4></div>
                    </div>
                </div>
                <div class="rateCalcNav">
                	<a href="home.php"><div class="calcicon"><img src="images/calculator.png" width="32" height="25" alt=""/></div>
                    Rate calculate</a>
                </div>
				<div class="clearfix"></div>
       	    	<div class="navPanel <?php if($_SESSION['admin_role']!=="1") {echo("hideMe");} ?>">
					<ul>
						<!--<li class="navItems"><i><img src="images/courier.png" width="32" height="25" alt=""/></i>Courier Companies</li>-->
						<li class="navItems"><a href="#" class="mainItem"><i><img src="images/rate.png" width="32" height="25" alt=""/></i>Rates</a>
							<ul class="subnav">
								<li class="navItems"><a href="view-rates.php">View Rates by Zone</a></li>
								<li class="navItems"><a href="edit-rates.php">Edit Rates</a></li>
							</ul>
						</li>
						
						<li class="navItems"><a href="#" class="mainItem"><i><img src="images/zone.png" width="32" height="25" alt=""/></i>Zones</a>
							<ul class="subnav">
								<li class="navItems"><a href="view-zones.php">View Zone</a></li>
								<!--<li class="navItems"><a href="edit-zones.php">Edit Zone</a></li>-->
							</ul>
						</li>
						<li class="navItems"><a href="#" class="mainItem"><i><img src="images/countries.png" width="32" height="25" alt=""/></i>Countries</a>
							<ul class="subnav">
								<li class="navItems"><a href="view-countries.php">View Countries</a></li>
								<li class="navItems"><a href="add-country.php">Add Countries</a></li>
							</ul>
						</li>
						<!--<li class="navItems"><i><img src="images/logout.png" width="32" height="25" alt=""/></i>Logout</li>-->
					</ul>
				
				</div>
            </div>