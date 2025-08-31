<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Join Space - Connect Space</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
      max-width: 400px;
      margin: auto;
    }

    .container h1 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: #111;
    }

    .container p {
      font-size: 1rem;
      color: #555;
      margin-bottom: 25px;
    }

    input {
      width: 100%;
      padding: 14px;
      font-size: 1rem;
      border: 1px solid #ddd;
      border-radius: 10px;
      margin-bottom: 20px;
      outline: none;
      transition: border 0.2s ease;
    }

    input:focus {
      border-color: #2563eb;
    }

    .btn {
      width: 100%;
      padding: 14px;
      font-size: 1.1rem;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }

    .btn-join {
      background: #2563eb;
      color: #fff;
    }

    .btn-scan {
      background: #f3f4f6;
      color: #111;
      border: 1px solid #ddd;
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
    <h1>Join a Space</h1>
    <p>Enter the space code provided or scan the QR code to join instantly.</p>

    <input value='<?=$Code?>' type="text" id="spaceCode" placeholder="Enter space code (e.g. ABCD-1234)">
    <label for="" style='color:red;font-size:13px'><?=$Error?></label>
    <button class="btn btn-join" onclick="joinSpace()">Join</button>
    <button class="btn btn-scan" onclick="scanQR()">📷 Scan QR</button>
  </main>

  <footer>
    © 2025 Connect Space. All rights reserved.
  </footer>

  <script>
    function joinSpace() {
      const code = document.getElementById("spaceCode").value.trim();
      if (code === "") {
        alert("Please enter a space code.");
      } else {
        window.location.href ="<?=site_url("Space/SetAll2")."?Code="?>"+code;
      }
    }

    function scanQR() {
      window.open("https://lens.google.com", "_blank");
    }
  </script>
</body>
</html>
