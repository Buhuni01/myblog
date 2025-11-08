// script.js - password toggle + AJAX auth + helpers
function showAlert(title, text, icon='info', autoMs=0){
  const opts = { title, text, icon, confirmButtonColor:'#ffc107' };
  if (autoMs>0){ opts.timer = autoMs; opts.showConfirmButton = false; }
  Swal.fire(opts);
}

document.querySelectorAll('.toggle-password').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    const target = btn.dataset.target;
    const input = document.getElementById(target);
    const icon = btn.querySelector('i');
    if (!input) return;
    if (input.type === 'password'){ input.type='text'; icon.classList.replace('bi-eye-slash','bi-eye'); }
    else { input.type='password'; icon.classList.replace('bi-eye','bi-eye-slash'); }
  });
});

// Register (AJAX)
const signupForm = document.getElementById('signupForm');
if (signupForm){
  signupForm.addEventListener('submit', async (e)=>{
    e.preventDefault();
    const fd = new FormData(signupForm);
    const p = fd.get('password'), c = fd.get('confirmPassword');
   if (p.length < 6) {
  showAlert('Error', 'Password must be at least 6 characters long', 'error');
  return;
}
if (p !== c) {
  showAlert('Error', 'Passwords do not match', 'error');
  return;
}

    try {
      const res = await fetch('register_action.php', { method:'POST', body: fd });
      const data = await res.json();
      if (data.status === 'success'){
        showAlert('Success', data.message, 'success', 1400);
        setTimeout(()=> location.href='signIn.php', 1500);
      } else {
        showAlert('Error', data.message, 'error');
      }
    } catch (err) {
      console.error(err);
      showAlert('Error','Server error', 'error');
    }
  });
}

// Login (AJAX)
const signinForm = document.getElementById('signinForm');
if (signinForm){
  signinForm.addEventListener('submit', async (e)=>{
    e.preventDefault();
    const fd = new FormData(signinForm);
    try {
      const res = await fetch('login_action.php', { method:'POST', body: fd });
      const data = await res.json();
      if (data.status === 'success'){
        showAlert('Welcome', data.message, 'success', 1000);
        setTimeout(()=> location.href = 'index.php', 1100);
      } else {
        showAlert('Error', data.message, 'error');
      }
    } catch (err) {
      console.error(err);
      showAlert('Error','Server error','error');
    }
  });
}

// simple search redirect
function searchBlogs() {
  const q = document.getElementById('searchInput').value.trim();
  if (!q) return;
  location.href = 'index.php?search=' + encodeURIComponent(q);
}


//Link Share function
document.querySelectorAll('.share-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const postUrl = `${window.location.origin}/view_post.php?id=${btn.dataset.id}`;
    navigator.clipboard.writeText(postUrl)
      .then(() => alert("Blog link copied to clipboard!"))
      .catch(() => alert("Failed to copy link."));
  });
});



//Create post function
document.addEventListener('DOMContentLoaded', ()=> {
  new SimpleMDE({ element: document.getElementById('mdContent'), spellChecker:false, placeholder:'Write your blog in Markdown...' });
});

const form = document.getElementById("createPostForm");
form.addEventListener("submit", function (e) {
  const content = simplemde.value().trim();
  if (content === "") {
    e.preventDefault();
    Swal.fire("Error", "Please enter blog content before publishing!", "error");
    return;
  }
  simplemde.codemirror.save();
});

//edit post function
document.addEventListener('DOMContentLoaded', ()=> {
  new SimpleMDE({ element: document.getElementById('mdContent'), spellChecker:false });
});



