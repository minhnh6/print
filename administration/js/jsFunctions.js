// Count Characters
function count(ele1, ele2, cntlim)
{
	var textcheck=document.getElementById(ele1).value;
	if(textcheck.length>cntlim) {
		document.getElementById(ele1).value=textcheck.substring(0,cntlim)
		return false;	
	} else {
		document.getElementById(ele2).innerHTML = cntlim-textcheck.length + '';
		return;
	}
}

function DateTypeEdit()  {
  	if (document.editnews.datetype.value=='') {
		document.getElementById("NoDate").style.display='none';		
		document.getElementById("Single").style.display='none';
	} else if (document.editnews.datetype.value=='N') {
		document.getElementById("NoDate").style.display='block';
		document.getElementById("Single").style.display='none';
	} else if (document.editnews.datetype.value=='S') {
		document.getElementById("NoDate").style.display='none';		
		document.getElementById("Single").style.display='block';
	} else if (document.editnews.datetype.value=='D') {
		document.getElementById("NoDate").style.display='none';		
		document.getElementById("Single").style.display='none';
	} 
}

function DateTypeAdd()  {
  	if (document.addnews.datetype.value=='') {
		document.getElementById("Single").style.display='none';
	} else if (document.addnews.datetype.value=='N') {
		document.getElementById("Single").style.display='none';
	} else if (document.addnews.datetype.value=='S') {
		document.getElementById("Single").style.display='block';
	}
}

function ExpireEdit()  {
  	if (document.editcoupon.expires.value=='1') {
		document.getElementById("YesExpire").style.display='block';		
		document.getElementById("NoExpire").style.display='none';
	} else if (document.editcoupon.expires.value=='0') {
		document.getElementById("YesExpire").style.display='none';		
		document.getElementById("NoExpire").style.display='block';
	} else if (document.editcoupon.expires.value=='') {
		document.getElementById("YesExpire").style.display='none';		
		document.getElementById("NoExpire").style.display='none';
	} 
}

function ExpireAdd()  {
  	if (document.addcoupon.expires.value=='1') {
		document.getElementById("YesExpire").style.display='block';		
		document.getElementById("NoExpire").style.display='none';
	} else if (document.addcoupon.expires.value=='0') {
		document.getElementById("YesExpire").style.display='none';		
		document.getElementById("NoExpire").style.display='block';
	} else if (document.addcoupon.expires.value=='') {
		document.getElementById("YesExpire").style.display='none';		
		document.getElementById("NoExpire").style.display='none';
	} 
}

function EventDateType()  {
  	if (document.editheadline.datetype.value=='') {
		document.getElementById("Single").style.display='block';
		document.getElementById("Double").style.display='none';
	} else if (document.editheadline.datetype.value=='S') {
		document.getElementById("Single").style.display='block';
		document.getElementById("Double").style.display='none';
	} else if (document.editheadline.datetype.value=='D') {
		document.getElementById("Single").style.display='none';
		document.getElementById("Double").style.display='block';
	} 
}
function MenuTypeEdit()  {
	if (document.editpage.mpID.value=='1') {
		document.getElementById("SubPageEdit").style.display='none';
	} else if (document.editpage.mpID.value=='2') {
		document.getElementById("SubPageEdit").style.display='block';		
	} 
}

function MenuTypeAdd()  {
	if (document.addpage.mpID.value=='0') {
		document.getElementById("SubPageAdd").style.display='none';
	} else if (document.addpage.mpID.value=='1') {
		document.getElementById("SubPageAdd").style.display='none';
	} else if (document.addpage.mpID.value=='2') {
		document.getElementById("SubPageAdd").style.display='block';		
	} 
}

function PageTypeAdd()  {
	if (document.addpage.pagetype.value=='') {
		document.getElementById("PageType").style.display='none';	
		document.getElementById("PageTypeCM").style.display='none';	
		document.addpage.showmenu.value='';							
		document.addpage.menuname.value='';	
		document.addpage.parentname.value='';	
		document.addpage.mpID.value='';	
		document.addpage.subof.value='';		
	} else if (document.addpage.pagetype.value=='M') {
		document.getElementById("PageType").style.display='block';		
		document.getElementById("PageTypeCM").style.display='none';				
		document.addpage.showmenu.value='';				
		document.addpage.menuname.value='';	
		document.addpage.parentname.value='';	
		document.addpage.mpID.value='';	
		document.addpage.subof.value='';		
	} else if (document.addpage.pagetype.value=='C') {
		document.addpage.showmenu.value='';				
		document.getElementById("PageType").style.display='none';	
		document.getElementById("PageTypeCM").style.display='none';				
		document.addpage.menuname.value='';	
		document.addpage.parentname.value='';	
		document.addpage.mpID.value='';	
		document.addpage.subof.value='';		
	} else if (document.addpage.pagetype.value=='CM') {		
		document.getElementById("PageType").style.display='none';	
		document.getElementById("PageTypeCM").style.display='block';			
		document.addpage.showmenu.value='';					
		document.addpage.menuname.value='';	
		document.addpage.parentname.value='';	
		document.addpage.mpID.value='';	
		document.addpage.subof.value='';			
	} 
}

function PageTypeEdit()  {
	if (document.editpage.pagetype.value=='') {
		document.getElementById("PageType").style.display='none';	
		document.getElementById("PageTypeCM").style.display='none';							
		document.editpage.showmenu.value='';			
		document.editpage.menuname.value='';	
		document.editpage.parentname.value='';	
		document.editpage.mpID.value='';	
		document.editpage.subof.value='';	
	} else if (document.editpage.pagetype.value=='M') {
		document.getElementById("PageType").style.display='block';	
		document.getElementById("PageTypeCM").style.display='none';							
		document.editpage.showmenu.value='';					
		document.editpage.menuname.value='';	
		document.editpage.parentname.value='';	
		document.editpage.mpID.value='';	
		document.editpage.subof.value='';			
	} else if (document.editpage.pagetype.value=='C') {		
		document.getElementById("PageType").style.display='none';	
		document.getElementById("PageTypeCM").style.display='none';					
		document.editpage.showmenu.value='';					
		document.editpage.menuname.value='';	
		document.editpage.parentname.value='';	
		document.editpage.mpID.value='';	
		document.editpage.subof.value='';			
	} else if (document.editpage.pagetype.value=='CM') {		
		document.getElementById("PageType").style.display='none';	
		document.getElementById("PageTypeCM").style.display='block';			
		document.editpage.showmenu.value='';					
		document.editpage.menuname.value='';	
		document.editpage.parentname.value='';	
		document.editpage.mpID.value='';	
		document.editpage.subof.value='';			
	} 
}

function SidebarAdd()  {
	if (document.addpage.sidebar.value=='') {
		document.getElementById("Sidebar").style.display='none';	
	} else if (document.addpage.sidebar.value=='0') {
		document.getElementById("Sidebar").style.display='none';	
	} else if (document.addpage.sidebar.value=='1') {
		document.getElementById("Sidebar").style.display='block';	
	} else if (document.addpage.sidebar.value=='2') {		
		document.getElementById("Sidebar").style.display='block';	
	}
}

function SidebarEdit()  {
	if (document.editpage.sidebar.value=='') {
		document.getElementById("Sidebar").style.display='none';	
	} else if (document.editpage.sidebar.value=='0') {
		document.getElementById("Sidebar").style.display='none';	
	} else if (document.editpage.sidebar.value=='1') {
		document.getElementById("Sidebar").style.display='block';	
	} else if (document.editpage.sidebar.value=='2') {		
		document.getElementById("Sidebar").style.display='block';	
	}
}

function UseImageAdd()  {
	if (document.addstaff.useimage.value=='') {
		document.getElementById("UploadImage").style.display='none';
	} else if (document.addstaff.useimage.value=='1') {
		document.getElementById("UploadImage").style.display='block';
	} else if (document.addstaff.useimage.value=='0') {
		document.getElementById("UploadImage").style.display='none';		
	} 
}

function UseImageEdit()  {
	if (document.editstaff.useimage.value=='') {
		document.getElementById("UploadImage").style.display='none';
	} else if (document.editstaff.useimage.value=='1') {
		document.getElementById("UploadImage").style.display='block';
	} else if (document.editstaff.useimage.value=='0') {
		document.getElementById("UploadImage").style.display='none';		
	} 
}

function StaffTypeAdd()  {
	document.getElementById("btitle").style.display='none';		
	document.getElementById("bqua").style.display='none';		
	if (document.getElementById("typeofstaff").value=='') {
		document.getElementById("Educational").style.display='none';
		document.getElementById("Board").style.display='none';	
	} else if (document.getElementById("typeofstaff").value=='A') {
		document.getElementById("Educational").style.display='none';
		document.getElementById("Board").style.display='none';
		document.getElementById("btitle").style.display='block';	
		document.getElementById("bqua").style.display='block';			
	} else if (document.getElementById("typeofstaff").value=='E') {
		document.getElementById("Educational").style.display='block';
		document.getElementById("Board").style.display='none';
		document.getElementById("bqua").style.display='block';		
	} else if (document.getElementById("typeofstaff").value=='B') {
		document.getElementById("Educational").style.display='none';
		document.getElementById("Board").style.display='block';
		document.getElementById("bqua").style.display='block';		
	} else if (document.getElementById("typeofstaff").value=='T') {
		document.getElementById("Educational").style.display='none';
		document.getElementById("Board").style.display='none';
		document.getElementById("btitle").style.display='block';
		document.getElementById("bqua").style.display='block';			
	} else if (document.getElementById("typeofstaff").value=='TA') {
		document.getElementById("Educational").style.display='none';
		document.getElementById("Board").style.display='none';	
	} else if (document.getElementById("typeofstaff").value=='DA') {
		document.getElementById("Educational").style.display='none';
		document.getElementById("Board").style.display='none';
				
	} 
}

function showimage1() {
	if (!document.images)
	return
	document.images.headerpreview.src=
	document.editpage.headerpath.options[document.editpage.headerpath.selectedIndex].value
}

function showquote1() {
	if (!document.images)
	return
	document.images.quotepreview.src=
	document.editpage.quotepath.options[document.editpage.quotepath.selectedIndex].value
}

function showimage2() {
	if (!document.images)
	return
	document.images.headerpreview.src=
	document.addpage.headerpath.options[document.addpage.headerpath.selectedIndex].value
}

function showquote2() {
	if (!document.images)
	return
	document.images.quotepreview.src=
	document.addpage.quotepath.options[document.addpage.quotepath.selectedIndex].value
}