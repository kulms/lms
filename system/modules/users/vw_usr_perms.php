<?php 
/*
global $AppUI, $user_id, $canEdit, $tab;

$pgos = array(
	'files' => 'file_name',
	'users' => 'user_username',
	'projects' => 'project_name',
	'tasks' => 'task_name',
	'companies' => 'company_name',
	'forums' => 'forum_name'
);

$pvs = array(
'-1' => 'read-write',
'0' => 'deny',
'1' => 'read only'
);


//Pull User perms
$sql = "
SELECT u.user_id, u.user_username,
	p.permission_item, p.permission_id, p.permission_grant_on, p.permission_value,
	c.company_id, c.company_name,
	pj.project_id, pj.project_name,
	t.task_id, t.task_name,
	f.file_id, f.file_name,
	fm.forum_id, fm.forum_name,
	u2.user_id, u2.user_username
FROM users u, permissions p
LEFT JOIN companies c ON c.company_id = p.permission_item and p.permission_grant_on = 'companies'
LEFT JOIN projects pj ON pj.project_id = p.permission_item and p.permission_grant_on = 'projects'
LEFT JOIN tasks t ON t.task_id = p.permission_item and p.permission_grant_on = 'tasks'
LEFT JOIN files f ON f.file_id = p.permission_item and p.permission_grant_on = 'files'
LEFT JOIN users u2 ON u2.user_id = p.permission_item and p.permission_grant_on = 'users'
LEFT JOIN forums fm ON fm.forum_id = p.permission_item and p.permission_grant_on = 'forums'
WHERE u.user_id = p.permission_user
	AND u.user_id = $user_id
";

$res = db_exec( $sql );

//pull the projects into an temp array
$tarr = array();
while ($row = db_fetch_assoc( $res )) {
	$item = @$row[@$pgos[$row['permission_grant_on']]];
	if (!$item) {
		$item = $row['permission_item'];
	}
	if ($item == -1) {
		$item = 'all';
	}
	$tarr[] = array_merge( $row, array( 'grant_item'=>$item ) );
}

// read the installed modules
$modules = arrayMerge( array( 'all'=>'all' ), $AppUI->getActiveModules( 'modules' ));
*/
?>

<script language="javascript">
function editPerm( id, gon, it, vl, nm ) {
/*
	id = Permission_id
	gon =permission_grant_on
	it =permission_item
	vl =permission_value
	nm = text representation of permission_value
*/
//alert( 'id='+id+'\ngon='+gon+'\nit='+it+'\nvalue='+vl+'\nnm='+nm);
	var f = document.frmPerms;

	f.sqlaction2.value="edit";
	
	f.permission_id.value = id;
	f.permission_item.value = it;
	//f.permission_item_name.value = nm;
	for(var i=0, n=f.permission_grant_on.options.length; i < n; i++) {
		if (f.permission_grant_on.options[i].value == gon) {
			f.permission_grant_on.selectedIndex = i;
			break;
		}
	}
	f.permission_value.selectedIndex = vl+1;
	//f.permission_item_name.value = nm;
}

function clearIt(){
	var f = document.frmPerms;
	f.sqlaction2.value = "add";
	f.permission_id.value = 0;
	f.permission_grant_on.selectedIndex = 0;
}

function delIt(id) {
	if (confirm( 'Are you sure you want to delete this permission?' )) {
		var f = document.frmPerms;
		f.del.value = 1;
		f.permission_id.value = id;
		f.submit();
	}
}

var tables = new Array;
tables['companies'] = 'companies';
tables['departments'] = 'departments';
tables['projects'] = 'projects';
tables['tasks'] = 'tasks';
tables['forums'] = 'forums';

function popPermItem() {
	var f = document.frmPerms;
	var pgo = f.permission_grant_on.options[f.permission_grant_on.selectedIndex].value;
	if (!(pgo in tables)) {
		alert( 'No list associated with this Module.' );
		return;
	}
	window.open('./index.php?m=public&a=selector&dialog=1&callback=setPermItem&table=' + tables[pgo], 'selector', 'left=50,top=50,height=250,width=400,resizable')
}

// Callback function for the generic selector
function setPermItem( key, val ) {
	var f = document.frmPerms;
	if (val != '') {
		f.permission_item.value = key;
		//f.permission_item_name.value = val;
	} else {
		f.permission_item.value = '-1';
		//f.permission_item_name.value = 'all';
	}
}
</script>

<table width="100%" border="0" cellpadding="2" cellspacing="0">
<tr><td width="50%" valign="top">

<table width="100%" border="0" cellpadding="2" cellspacing="1" class="tbl">
<tr>
	<th>&nbsp;</th>
	<th nowrap="nowrap" width="60%"><?php echo $user->_('Module');?></th>	
	<th nowrap><?php echo $user->_('Type');?></th>
	<th>&nbsp;</th>
</tr>

<?php
/*
foreach ($tarr as $row){
	$buf = '';

	$buf .= '<td nowrap>';
	if ($canEdit) {
		$buf .= "<a href=# onClick=\"editPerm({$row['permission_id']},'{$row['permission_grant_on']}',{$row['permission_item']},{$row['permission_value']},'{$row['grant_item']}');\" title=\"".$AppUI->_('edit')."\">"
			. dPshowImage( './images/icons/stock_edit-16.png', 16, 16, '' )
			. "</a>";
	}
	$buf .= '</td>';

	$style = '';
	if($row['permission_grant_on'] == "all" && $row['permission_item'] == -1 && $row['permission_value'] == -1) {
		$style =  'style="background-color:#ffc235"';
	} else if($row['permission_item'] == -1 && $row['permission_value'] == -1) {
		$style = 'style="background-color:#ffff99"';
	}

	$buf .= "<td $style>" . $row['permission_grant_on'] . "</td>";

	$buf .= "<td>" . $row['grant_item'] . "</td><td nowrap>" . $pvs[$row['permission_value']] . "</td>";

	$buf .= '<td nowrap>';
	if ($canEdit) {
		$buf .= "<a href=# onClick=\"delIt({$row['permission_id']});\" title=\"".$AppUI->_('delete')."\">"
			. dPshowImage( './images/icons/stock_delete-16.png', 16, 16, '' )
			. "</a>";
	}
	$buf .= '</td>';
	
	echo "<tr>$buf</tr>";
}
*/
?>
</table>

<table>
<tr>
	<td><?php echo $user->_('Key');?>:</td>
	<td>&nbsp; &nbsp;</td>
	<td bgcolor="#ffc235">&nbsp; &nbsp;</td>
	<td>= <?php echo $user->_('Super User');?></td>
	<td>&nbsp; &nbsp;</td>
	<td bgcolor="#ffff99">&nbsp; &nbsp;</td>
	<td>= <?php echo $user->_('full access to module');?></td>
</tr>
</table>


</td><td width="50%" valign="top">



<table cellspacing="0" cellpadding="2" border="0" class="std" width="100%">
        <form name="frmPerms" method="post" action="./index.php?m=users">
          <input type="hidden" name="del" value="0" />
          <input type="hidden" name="dosql" value="do_perms_aed" />
          <input type="hidden" name="user_id" value="<?php echo $user_id;?>" />
          <input type="hidden" name="permission_user" value="<?php echo $user_id;?>" />
          <input type="hidden" name="permission_id" value="0" />
          <input type="hidden" name="permission_item" value="-1" />
          <tr> 
            <th colspan="2" ><?php echo $user->_('Add or Edit Permissions');?></th>
          </tr>
          <tr> 
            <td width="15%" align="right" nowrap ><?php echo $user->_('Module');?>:</td>
            <td width="85%" > 
              <?php //echo arraySelect($modules, 'permission_grant_on', 'size="1" class="text"', 'all');?>
			  <select name="permission_grant_on" style="font-size:10px">
                <option value="0">-select-</option>
                <option value="1">Forum</option>
                <option value="2">Webboard</option>
                <option value="3">Resources</option>
				<option value="4">Quiz</option>
				<option value="5">Homework</option>
              </select>
            </td>
          </tr>
          <tr> 
            <td nowrap align="right" ><?php echo $user->_('Level');?>:</td>
            <td > 
              <?php //echo arraySelect($pvs, 'permission_value', 'size="1" class="text"', 0);?>
              <select name="permission_value" style="font-size:10px">
                <option value="0">- select -</option>
                <option value="1">read - write</option>
                <option value="2">deny</option>
                <option value="3">read  only</option>
              </select> </td>
          </tr>
          <tr> 
            <td class="hilite"> <input type="submit" value="<?php echo $user->_('add');?>" class="button" name="sqlaction2">
            </td>
            <td class="hilite" align="right"><input type="reset" value="<?php echo $user->_('clear');?>" class="button" name="sqlaction" onClick="clearIt();"></td>
          </tr>
        </form>
      </table>



</td>
</tr>

</table>
