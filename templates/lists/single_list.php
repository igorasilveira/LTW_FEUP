<h2><?=$main_info['name']?></h2>
<h4>Created by <?=$creator?> on <?=$main_info['date_created']?></h4>
<?if (in_array( $_SESSION['username'], $listUsers, true) || !isset($_SESSION['username'])) {?>
<ul id="items_list">
  <h3>List Items</h3>
  <?if (empty($listItems)) {?>
    <li>
      No items were added here yet.
    </li>
  <?} else
  foreach ($listItems as $item) {?>
    <li <?if ($item['done'] == 1) {
      echo 'style="text-decoration: line-through"';

    }$name = str_replace(' ', '_', $item['description']);?>>
      <input type="checkbox" name="<?=$name?>" <?= ($item['done'] == 1 ? 'checked' : '');?>disabled>
      <span class="item"><?=$item['description']?></span>
      <input type="hidden" value="<?=$item['description']?>" name="items[]"/>
    </li>
  <?}?>
</ul>
<div id="new_item" style="display: none">
  <label>
    New Item: <input type="text" id="item"/>
    <button type="button" onclick="addItem()">Add</button>
  </label>
</div>
<ul id="users_list">
  <h3>Users</h3>
  <?if (empty($listUsers)) {?>
    <li>
      No users were added here yet.
    </li>
  <?}foreach ($listUsers as $user) {?>
    <li>
      <span class="username"><?=$user['username']?></span>
      <input type="hidden" value="<?=$user['username']?>" name="users[]"/>
    </li>
  <?}?>
</ul>
<form action='edit_list.php' method="get">
  <input type="hidden" name="id" value="<?=$_GET['id']?>"/>
  <button>Edit</button>
</form>
<?} else {?>
    <h3>You do not have access to this list.</h3>
  <?}?>
