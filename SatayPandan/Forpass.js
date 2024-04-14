function goBack() {
    // This would be replaced with actual navigation in a real application
    alert('Go back to the previous page.');
  }
  
  function returnToLogin() {
    // This would be replaced with actual navigation in a real application
    alert('Return to the login page.');
  }
  
  // Adding event listener for form submission
  document.getElementById('resetForm').addEventListener('submit', function(event) {
    event.preventDefault();
    var email = document.getElementById('email').value;
    // Here you would typically send the email to your backend server
    alert('Password reset link has been sent to ' + email);
  });
  