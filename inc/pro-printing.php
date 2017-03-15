
<h2 class="printing-option-title"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i>Get Started Here</h2>
        <div class="printing-option">
		<form action="<?php echo LINK_PATH;?>shopCart.php" method="post" name="IPCalculator" id="IPCalculator">
		
          <h4>Printing Options</h4>
		  <span>Select Type </span>
          <?php
			ShowType($rowpro['cat_id'],$rowpro['id']);
			 $sqlopt="SELECT * FROM option_type";
                $resopt=mysql_query($sqlopt);
                while($rowopt=mysql_fetch_assoc($resopt)){
                    ShowOptions($rowpro['cat_id'],$rowopt['id'],$rowopt['typename']);
                }
               ?>
			     <span>Hole Placement </span>
				  <select class="selectpicker">
					<option>None</option>
					<option selected="selected"> Top Left </option>
					<option>Top Center</option>
					<option>Top Right </option>
					<option>Left Center</option>
					<option>Right Center</option>
				  </select>
				  <span>Rounded Corners</span>
				  <select class="selectpicker">
					<option selected="selected"> No </option>
					<option>Yes</option>
				  </select>
				 
			<div class="nav nav-tabs tabs-left sideways" id="sideways">
				<label>
				  <input type="radio"  name="RadioGroup1" class="rgt" value="radio" id="RadioGroup1_0">
				  <a href="#home-v"  data-toggle="tab">Upload File Now </a></label>
				<br>
				<label>
				  <input type="radio" name="RadioGroup1" class="rgt" value="radio" id="RadioGroup1_1">
				  <a href="#profile-v"  data-toggle="tab">Design Your File Online </a></label>
				<br>
				<label>
              <input type="radio" checked="checked" class="rgt" name="RadioGroup1" value="radio" id="RadioGroup1_2">
              <a href="#messages-v"  data-toggle="tab">Buy Now/Upload Later </a></label>
          </div>
			<input type="hidden" name="action" id="add" value="add">
            <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $rowpro['cat_id'];?>" />
            <input type="hidden" name="pro_id" id="pro_id" value="<?php echo $rowpro['id'];?>" />
            <input type="hidden" name="hide_result" id="hide_result" value="<?php echo $rowpro['baseprice'];?>" />
            <input type="hidden" name="base" id="base" value="<?php echo $rowpro['baseprice'];?>" />
			<input type="hidden" name="base" id="base" value="<?php echo $rowpro['baseprice'];?>" />
			<input type="hidden" name="result" id="result" value="<?php echo $rowpro['baseprice'];?>" />
			 <div class="printing-cost">
				<h3>Printing Cost: <span>$<span class="result1"><?php echo $rowpro["baseprice"];?></span></span></h3>
				<small>Only $0.16 each</small> 
		   </div> 
        
		     <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane" id="home-v">
              <button id="orderPageFormBtn" class="btn btn-primary btn-block btn-lg " data-qaid="submitButton" type="button">CONTINUE</button>
            </div>
            <div class="tab-pane" id="profile-v">
              <button id="orderPageFormBtn" class="btn btn-primary btn-block btn-lg " data-qaid="submitButton" type="button">START DESIGNING</button>
            </div>
            <div class="tab-pane active" id="messages-v">
              <button id="orderPageFormBtn" <?php if($rowpro['iscustom']!=1){?> onclick="document.getElementById('IPCalculator').submit();" <?php } ?> class="btn btn-primary btn-block btn-lg " data-qaid="submitButton" type="button">ADD TO CART</button>
            </div>
          </div>
			  
			  
			</div>
		</form>
	</div>
