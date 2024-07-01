function clearForm(form) {
  form.reset();
  // Replace the URL to remove query parameters
  window.history.replaceState(null, null, window.location.pathname);
  window.location.reload();
}

function removeEmptyFields(form) {
  var inputs = form.getElementsByTagName("input");
  for (var i = inputs.length - 1; i >= 0; i--) {
    if (inputs[i].value === "") {
      inputs[i].parentNode.removeChild(inputs[i]);
    }
  }
}

// function removeEmptyFields(form) {
//     var inputs = form.getElementsByTagName("input");
//     for (let input of Array.from(inputs).reverse()) {
//       if (input.value === "") {
//         input.parentNode.removeChild(input);
//       }
//     }
//   }
