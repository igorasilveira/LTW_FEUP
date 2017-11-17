<form action="action_save_list.php" method="post">
  <input type="hidden" name="creator" value="<?=$creator['username']?>"/>
  <label>
    Title <input type="text" name="name" value="<?=$title?>"/>
  </label>
  <ul id="items_list">
    <h3>Items List</h3><?
    foreach ($listItems as $item) {?>
      <li>
        <input type="checkbox" name="<?=$item['description']?>" <?= ($item['done'] == 1 ? 'checked' : '');?>>
        <?=$item['description']?>
        <input type="hidden" value="<?=$item['description']?>"  name="items[]"/>
        <button type="button" class="delete-button">X</button>
      </li>
    <?}
    ?>
  </ul>
  <label>
    New Item: <input type="text" id="item"/>
    <button type="button" onclick="addItem()">Add</button>
  </label>
  <ul id="users_list">
      <h3>Users Added</h3><?
      foreach ($listUsers as $user) {?>
          <li>
            <?=$user['username']?>
            <input type="hidden" value="<?=$user['username']?>" name="users[]"/>
            <button type="button" class="delete-button">X</button>
          </li>
      <?}
    ?>
  </ul>
  <label>
    Username: <input type="text" id="user"/>
    <button type="button" onclick="addUser()">Add</button>
  </label>
  <input type="submit" value="Save"/>
</form>
<button id="delete_button" type="button" class="red-btn" onclick="deleteList()">Delete List</button>