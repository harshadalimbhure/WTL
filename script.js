function performOperations() {
    const num1 = parseFloat(document.getElementById('num1').value);
    const num2 = parseFloat(document.getElementById('num2').value);
    
    // Validate input
    if (isNaN(num1) || isNaN(num2)) {
      alert("Please enter valid numbers.");
      return;
    }
  
    // Perform calculations
    const addition = num1 + num2;
    const subtraction = num1 - num2;
    const multiplication = num1 * num2;
    const division = num2 !== 0 ? (num1 / num2) : "Cannot divide by zero";
    const square1 = num1 * num1;
    const square2 = num2 * num2;
  
    // Display results
    document.getElementById('add-result').textContent = addition;
    document.getElementById('sub-result').textContent = subtraction;
    document.getElementById('mul-result').textContent = multiplication;
    document.getElementById('div-result').textContent = division;
    document.getElementById('square1-result').textContent = square1;
    document.getElementById('square2-result').textContent = square2;
  }
  