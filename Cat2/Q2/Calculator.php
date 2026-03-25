<?php include 'BackEndCalculator.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Super Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">
    <h2>PHP Super Calculator</h2>

    <form method="post">
        <center><label>First Number</label></center>
        <input type="number" name="num1" 
               value="<?php echo isset($_POST['num1']) ? '' : ''; ?>" required>

        <center><label>Second Number</label></center>
        <input type="number" name="num2" 
               value="<?php echo isset($_POST['num2']) ? '' : ''; ?>" required>

        <center><label>Operation</label></center>
        <select name="operation" required>
            <option value="">-- Select Operation --</option>
            <option value="add" <?php if(($_POST['operation'] ?? '') == 'add') echo 'selected'; ?>>Addition (+)</option>
            <option value="subtract" <?php if(($_POST['operation'] ?? '') == 'subtract') echo 'selected'; ?>>Subtraction (-)</option>
            <option value="multiply" <?php if(($_POST['operation'] ?? '') == 'multiply') echo 'selected'; ?>>Multiplication (*)</option>
            <option value="divide" <?php if(($_POST['operation'] ?? '') == 'divide') echo 'selected'; ?>>Division (/)</option>
        </select>

        <button type="submit" name="calculate">Calculate</button>
    </form>

    <div class="result-box">
        <input type="text" value="Result: <?php echo $result; ?>" readonly>
    </div>

    <div class="history">
        <h3>Calculation History</h3>
        <ul>
            <?php foreach ($_SESSION['history'] as $item): ?>
                <li><?php echo $item; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <form method="post">
        <button type="submit" name="clear" class="clear-btn">
            Clear History
        </button>
    </form>
</div>

</body>
</html>