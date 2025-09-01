<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>The Space</title>
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
      background: #f9fafb;
      display: flex;
      flex-direction: column;
      height: 100dvh;
    }

    header {
      background: #0b3798;
      color: #fff;
      padding: 15px 20px;
      font-size: 1.2rem;
      font-weight: 600;
      display:flex;
      justify-content:space-between;
    }

    .chat-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      padding: 20px;
      overflow-y: auto;
    }

    .msg {
      max-width: 75%;
      padding: 12px 16px;
      border-radius: 12px;
      margin: 8px 0;
      font-size: 0.95rem;
      line-height: 1.4;
      display: flex;
      flex-direction:column;
      word-wrap: break-word;
      overflow-wrap: break-word;
    }
    .msg span:first-child{
        font-size:10px;
    }

    .other {
      background: #e5e7eb;
      color: #111;
      align-self: flex-start;
      border-bottom-left-radius: 0;
      position: relative;
    }

    .me {
      background: #0b3798;
      color: #fff;
      align-self: flex-end;
      border-bottom-right-radius: 0;
      position: relative;
    }


    .input-container {
      display: flex;
      padding: 10px;
      background: #fff;
      border-top: 1px solid #ddd;
      gap: 8px;
    }

    .input-container input {
      flex: 1;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 10px;
      font-size: 1rem;
      outline: none;
      min-width: 0; /* important for flex shrink */
    }

    .input-container button {
      background: #0b3798;
      color: #fff;
      border: none;
      padding: 12px 18px;
      font-size: 1rem;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.2s;
      flex-shrink: 0;
    }

    .input-container button:hover {
      background: #1e4fd1;
    }
    .logout{
      background: #ff0000ff;
      border:none;
      border-radius:8px;
      padding: 5px 10px;
      color:white;
      cursor: pointer;
    }

    /* Scrollbar for chat */
    .chat-container::-webkit-scrollbar {
      width: 6px;
    }
    .chat-container::-webkit-scrollbar-thumb {
      background: #ccc;
      border-radius: 3px;
    }

    /* ✅ Responsive tweaks */
    @media (max-width: 600px) {
      header {
        font-size: 1rem;
        padding: 12px 15px;
      }

      .chat-container {
        padding: 12px;
      }

      .msg {
        max-width: 85%;
        font-size: 0.9rem;
        padding: 10px 12px;
      }
      .msg span:first-child{
        font-size:10px;
    }

      .input-container {
        padding: 8px;
        gap: 6px;
      }

      .input-container input {
        font-size: 0.9rem;
        padding: 10px;
      }

      .input-container button {
        padding: 10px 14px;
        font-size: 0.9rem;
      }
    }
    a{
      text-decoration:none;
      color:white;
      cursor: pointer;
    }
    #qrDisplay{
      display: none;
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: 2;
      backdrop-filter: blur(3px);
      align-items: center;
      justify-content: center;
      background-color:#00000029;
    }
    .ActiveQr{
      display: flex !important;
    }
    .qrBox{
      width: fit-content;
      height: fit-content;
      padding: 15px;
      background: white;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      gap:5px;
    }
    .qrBox>div>button{
      width: 30px;
      height: 30px;
      border-radius: 5px;
      border: none;
      background-color: #101010ff;
      color: white;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div id='qrDisplay'>
    <div class='qrBox'>
      <div style='display:flex;justify-content: end;width:100%;'><button onclick='openQR()'>X</button></div>
      <canvas id="qr"></canvas>
    </div>
  </div>
  <header>
    <span><a onclick='openQR()'><?=$Code?></a></span>
    <div>
      <a href="<?=site_url("Space/Logout")?>"><button class='logout'>Logout</button></a>
    </div>
  </header>

  <div class="chat-container" id="chatBox">
    
  </div>

  <div class="input-container">
    <input type="text" id="msgInput" placeholder="Type your message..." >
    <button onclick="sendMsg()">Send</button>
  </div>

  <script>
    const HostID=`<?=$HostID?>`;
    const DeviceID=`<?=$DeviceID?>`;
    const chatBox = document.getElementById("chatBox");
    function sendMsg() {
      const input = document.getElementById("msgInput");
      const msg = input.value.trim();
      if (msg === "") return;
      input.value = "";
      sentMsg(msg);
    }

    function sentMsg(msg){
      const data = new FormData();
        data.append("msg", msg);

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "SentMessage", true);

        xhr.onload = function () {
        if (xhr.status === 200) {
            console.log("Response from PHP:", xhr.responseText);
        } else {
            console.error("Error:", xhr.statusText);
        }
        };

        xhr.send(data);
    }

    let msgLength=-1;
    function getMsg(){
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "getmsg", true);

      xhr.onload = function () {
        if (xhr.status === 200) {
          try {
            const response = JSON.parse(xhr.responseText);
            if(msgLength!=response.length){
              if(response.length==0){
                chatBox.innerHTML=`<div class="msg other"><span>Space</span><span>Hey! Welcome to the space 👋<br>You can add multiple devices to a single space.</span></div>`
              }else{
                setBoxValue(response,msgLength)
              }
              msgLength=response.length;
            }
          } catch (e) {
            console.log("Raw response:", xhr.responseText);
          }
        } else {
          console.error("Error:", xhr.statusText);
        }
      };
      xhr.send();
    }
    setInterval(() => {
      getMsg()
    }, 100);


    function setBoxValue(Msg,counts){
      counts=(counts<0)?0:counts
      for(let i=counts;i<Msg.length;i++){
        let className=`other`;
        let Name=`Host`
        if(Msg[i].DeviceID==DeviceID){
          className=`me`;
          Name=`Me`;
        }else if(Msg[i].DeviceID!=HostID){
          Name=`Device${Msg[i].Num}`;
        }
        const msgDiv = document.createElement("div");
        msgDiv.classList.add("msg", className);
        msgDiv.innerHTML = `<span>${Name}</span><span>${makeLinks(Msg[i].Msg)}</span>`;
        chatBox.appendChild(msgDiv);
      }
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    function openQR(){
      alert("KK")
    }
    const code = `<?=$Code?>`;
    const qr = new QRious({
      element: document.getElementById("qr"),
      value: "<?=site_url("Space/Join")?>?Code="+code,
      size: 200
    });

    function openQR(){
      const Dis=document.getElementById("qrDisplay");
      if(Dis.classList.contains("ActiveQr")){
        Dis.classList.remove("ActiveQr");
      }else{
        Dis.classList.add("ActiveQr");
      }
    }
    function makeLinks(text) {
      const urlRegex = /(https?:\/\/[^\s]+|www\.[^\s]+)/g;

      return text.replace(urlRegex, function(url) {
        let href = url;
        if (!href.match(/^https?:\/\//)) {
          href = "http://" + href; 
        }
        return `<a style='color: #06b5eaff' href="${href}" target="_blank">${url}</a>`;
      });
    }
  </script>
</body>
</html>
