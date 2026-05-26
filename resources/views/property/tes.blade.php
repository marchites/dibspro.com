body {
background: #f5f6f8;
}

.app-container {
max-width: 480px;
margin: auto;
background: #fff;
min-height: 100vh;
padding-bottom: 90px;
}

.section {
padding: 15px;
}

.price {
font-size: 20px;
font-weight: bold;
color: #2c7be5;
}

.location {
font-size: 13px;
color: #777;
}

.spec-box {
display: flex;
justify-content: space-between;
text-align: center;
margin-top: 10px;
}

.spec-item {
flex: 1;
}

.cta-bar {
position: fixed;
bottom: 0;
width: 100%;
max-width: 480px;
background: #fff;
border-top: 1px solid #ddd;
padding: 10px;
display: flex;
gap: 10px;

left: 50%;
transform: translateX(-50%);
justify-content: space-around;
align-items: center;
z-index: 1000;
}

.btn-wa {
background: #25D366;
color: #fff;
flex: 1;
border-radius: 10px;
}

.btn-call {
flex: 1;
border-radius: 10px;
}

.btn-fav.active {
background: #dc3545;
color: #fff;
}