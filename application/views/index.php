<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connect Space</title>
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
    }

    .container h1 {
      font-size: 2.5rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: #111;
    }

    .container p {
      font-size: 1rem;
      color: #555;
      max-width: 600px;
      margin-bottom: 40px;
    }

    .btn-group {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
      justify-content: center;
    }

    .btn {
      padding: 14px 35px;
      font-size: 1.1rem;
      font-weight: 600;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-create {
      background: #2563eb;
      color: #fff;
    }

    .btn-join {
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

    @media (max-width: 600px) {
      .container h1 {
        font-size: 2rem;
      }

      .btn {
        width: 100%;
        padding: 14px;
      }

      .btn-group {
        flex-direction: column;
        gap: 15px;
        width: 100%;
        max-width: 300px;
      }
    }
  </style>
</head>
<body>
  <header>
    <h2>Connect Space</h2>
  </header>

  <main class="container">
    <h1>Seamless Device Connection</h1>
    <p>Quickly connect your laptop and phone in one shared space. Create a new space or join an existing one with just a click.</p>
    
    <div class="btn-group">
      <a href="<?=site_url("Space/Create")?>"><button class="btn btn-create">Create Space</button></a>
      <a href="<?=site_url("Space/Join")?>"><button class="btn btn-join">Join Space</button></a>
    </div>
  </main>

  <footer>
    © 2025 Connect Space. All rights reserved.
  </footer>
</body>
</html>
