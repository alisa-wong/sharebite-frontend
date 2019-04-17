<?php
include('includes/init.php');

// Add new section into sections table
if(isset($_POST['upload_section'])) {
    $name = filter_input(INPUT_POST, 'new_section_name', FILTER_SANITIZE_STRING);
    $sql = 'INSERT INTO sections (name) VALUES (:section_name)';
    $params = array( ':section_name' => $name );
    $result = exec_sql_query($db, $sql, $params);
}

// Upload new item
if(isset($_POST['upload_item'])) {
    // Add new item into items table
    $item = filter_input(INPUT_POST, 'new_item_name', FILTER_SANITIZE_STRING);
    $sql = 'INSERT INTO items (name) VALUES (:item_name)';
    $params = array( ':item_name' => $item );
    $result = exec_sql_query($db, $sql, $params);

    // Add new item into section_items table
    $itemID = $db->lastInsertId('id');
    $sql2 = 'INSERT INTO section_items (section_id, item_id) VALUES (:section_id, :item_id)';
    $params2 = array (
        ':section_id' => $_GET['section_id'],
        ':item_id' => $itemID
    );
    $result2 = exec_sql_query($db, $sql2, $params2);
}
?>

<!DOCTYPE html>
<html lang="en">
<header>
    <meta charset='UTF-8'/>
    <meta name='viewport' content='width=device-width, initial-scale=1'/>

    <title>Menu</title>

    <link rel='stylesheet' type='text/css' href='../styles/all.css' media='all'/>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script> 
    <script src="scripts/main.js"></script>
</header>
<body>
<div class='body'>
    <h1><a href='index.php'>Menu</a></h1>

    <div id='menu'>
        <div class='section_box box'>
            <h2>Menu Sections</h2>

            <button class='section_button1'>+</button>

            <div class='form hidden section_form'>
                <form id='upload_section' action='index.php' method='post' enctype='multipart/form-data'>
                    <h3>Add a New Section</h3>

                    <label for='new_section_name'>Section Name:</label>
                    <input type='text' id='new_section_name' name='new_section_name'/>

                    <button name='upload_section' type='submit'>Submit</button>
                </form>
                <button class='close1'>Close</button>
            </div>

            <?php
                //Get all menu sections
                $sql = 'SELECT id, name FROM sections';
                $params = array();
                $records = exec_sql_query($db, $sql, $params)->fetchAll();

                foreach($records as $section) {
                    
                    $path = 'index.php?' . http_build_query( array('section_id' => $section['id']) );
    
                    if ( isset($_GET['section_id']) && $section['id']==$_GET['section_id'] ) {
                        echo '<div class="section selected"><a href="' . $path . '">' . $section['name'] . '</a></div>';
                    } else {
                        echo '<div class="section"><a href="' . $path . '">' . $section['name'] . '</a></div>';
                    }
                }
            ?>

        </div>

        <div class='items_box box'>

            <h2>Section Items</h2>

            <?php
                if (isset($_GET['section_id'])) {
                    echo '<button class="section_button2">+</button>';

                    $path = 'index.php?' . http_build_query( array('section_id' => $section['id']) ); 
            ?>
                <div class='form hidden items_form'>
                    <form id='upload_item' action=<?php echo $path; ?> method='post' enctype='multipart/form-data'>
                        <h3>Add a New Item</h3>

                        <label for='new_item_name'>Item Name:</label>
                        <input type='text' id='new_item_name' name='new_item_name'/>

                        <button name='upload_item' type='submit'>Submit</button>
                    </form>
                    <button class='close2'>Close</button>
                </div>
            <?php } ?>

            <?php
            if (isset($_GET['section_id'])) {
                $sql = 'SELECT items.name FROM items LEFT OUTER JOIN section_items ON items.id = section_items.item_id WHERE section_items.section_id=:section;';
                $params = array( ':section' => $_GET['section_id'] );
                $result = exec_sql_query($db, $sql, $params)->fetchAll();
                foreach($result as $item) {
                    echo '<div class="item">' . $item['name'] . '</div>';
                }
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
