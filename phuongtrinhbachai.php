<?php

class LinearEquation {
    protected $a;
    protected $b;

    public function __construct($a, $b) {
        $this->a = $a;
        $this->b = $b;
    }

    public function solve() {
        if ($this->a == 0) {
            return $this->b == 0 ? "Phương trình vô số nghiệm" : "Phương trình vô nghiệm";
        }
        return "Nghiệm của phương trình bậc nhất: x = " . (-$this->b / $this->a);
    }
}

class QuadraticEquation extends LinearEquation {
    private $c;

    public function __construct($a, $b, $c) {
        parent::__construct($a, $b);
        $this->c = $c;
    }

    public function solve() {
        if ($this->a == 0) {
            return parent::solve();
        }
        $delta = $this->b * $this->b - 4 * $this->a * $this->c;
        if ($delta < 0) {
            return "Phương trình vô nghiệm";
        } elseif ($delta == 0) {
            return "Phương trình có nghiệm kép: x = " . (-$this->b / (2 * $this->a));
        } else {
            $x1 = (-$this->b + sqrt($delta)) / (2 * $this->a);
            $x2 = (-$this->b - sqrt($delta)) / (2 * $this->a);
            return "Phương trình có hai nghiệm: x1 = $x1, x2 = $x2";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $a = isset($_POST['a']) ? floatval($_POST['a']) : 0;
    $b = isset($_POST['b']) ? floatval($_POST['b']) : 0;
    $c = isset($_POST['c']) && $_POST['c'] !== "" ? floatval($_POST['c']) : null;

    if ($c === null) {
        $equation = new LinearEquation($a, $b);
    } else {
        $equation = new QuadraticEquation($a, $b, $c);
    }
    $result = $equation->solve();
} else {
    $result = "";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Giải phương trình</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://phongvu.vn/cong-nghe/wp-content/uploads/2024/09/130-hinh-nen-may-tinh-4k-78-1-1024x640.jpg');/* Đường dẫn ảnh 4K */
            background-size: cover;  /* Đảm bảo ảnh phủ toàn bộ màn hình */
            background-position: center; /* Căn giữa ảnh */
            background-repeat: no-repeat; /* Không lặp lại ảnh */
            /*background: linear-gradient(120deg, #f6d365, #fda085);*/
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            padding: 50px;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }
        input, button {
            margin: 10px;
            padding: 10px;
            border: none;
            border-radius: 5px;
        }
        button {
            background: #ff7e5f;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #ea5455;
        }
        p {
            font-size: 18px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form method="post">
        <label>Nhập a:</label>
        <input type="number" step="any" name="a" required>
        <br>
        <label>Nhập b:</label>
        <input type="number" step="any" name="b" required>
        <br>
        <label>Nhập c (tùy chọn):</label>
        <input type="number" step="any" name="c">
        <br>
        <button type="submit">Giải phương trình</button>
    </form>
    <p><?php echo $result; ?></p>
</body>
</html>
