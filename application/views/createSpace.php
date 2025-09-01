<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Space - Connect Space</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body {
      background: #ffffff;
      color: #222;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      width: 100%;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #eee;
    }

    header h2 {
      font-weight: 600;
      color: #333;
    }

    .container {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      text-align: center;
    }

    .container h1 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: #111;
    }

    .code-box {
      font-size: 1.5rem;
      font-weight: 600;
      color: #2563eb;
      letter-spacing: 3px;
      margin: 20px 0;
      padding: 12px 20px;
      border: 2px dashed #2563eb;
      border-radius: 10px;
      background: #f9fafb;
      display: inline-block;
    }

    canvas {
      margin: 20px 0;
      border: 5px solid #000000ff;
      border-radius: 40px;
      padding: 10px;
      background: #fff;
    }

    .btn {
      padding: 14px 35px;
      font-size: 1.1rem;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      background: #2563eb;
      color: #fff;
      margin-top: 30px;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    footer {
      padding: 20px;
      text-align: center;
      font-size: 0.9rem;
      color: #777;
      border-top: 1px solid #eee;
    }
  </style>
</head>
<body>
  <header>
    <h2>Connect Space</h2>
  </header>

  <main class="container">
    <h1>Your Space Code</h1>
    <div id="code" class="code-box">-- -- --</div>
    <canvas id="qr"></canvas>
    <a href="<?=site_url("Space/SetAll")."?Code=".$Code?>"><button class="btn">Next</button></a>
  </main>

  <footer>
    © 2025 Connect Space. All rights reserved.
  </footer>

  <script>

    const code = `<?=$Code?>`;
    document.getElementById("code").innerText = code;
    const qr = new QRious({
      element: document.getElementById("qr"),
      value: "<?=site_url("Space/Join")?>?Code="+code,
      size: 200
    });
  </script>
</body>
</html>
