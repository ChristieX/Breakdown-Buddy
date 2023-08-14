$("#form")
  .find("input, textarea")
  .on("keyup blur focus", function (e) {
    var $this = $(this),
      label = $this.prev("label");

    if (e.type === "keyup") {
      if ($this.val() === "") {
        label.removeClass("active highlight");
      } else {
        label.addClass("active highlight");
      }
    } else if (e.type === "blur") {
      if ($this.val() === "") {
        label.removeClass("active highlight");
      } else {
        label.removeClass("highlight");
      }
    } else if (e.type === "focus") {
      if ($this.val() === "") {
        label.removeClass("highlight");
      } else if ($this.val() !== "") {
        label.addClass("highlight");
      }
    }
  });

$(".tab a").on("click", function (e) {
  e.preventDefault();

  $(this).parent().addClass("active");
  $(this).parent().siblings().removeClass("active");

  target = $(this).attr("href");

  $(".tab-content > div").not(target).hide();

  $(target).fadeIn(800);
});

function Signup() {
  const full_name =
    document.getElementById("first_name").value +
    " " +
    document.getElementById("last_name").value;

  const Email = document.getElementById("email").value;
  const PhoneNumber = document.getElementById("phone").value;
  const Password = document.getElementById("password").value;

  fetch("http://127.0.0.1:3000/StoreDB", {
    method: "post",
    body: JSON.stringify({
      Fullname: full_name,
      Email: Email,
      PhoneNumber: PhoneNumber,
      Password: Password,
    }),
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
  })
    .then((r) => r.json())
    .then((data) => {
      console.log(data);
      if (data.resp == "Pass") {
        window.location.href = "signup.html?User=" + full_name;
      }
    });
}

function Login() {
  const full_name = document.getElementById("full_name").value;
  const DOB = document.getElementById("date_of_birth").value;

  fetch("http://127.0.0.1:3000/LoginDB", {
    method: "post",
    body: JSON.stringify({
      Fullname: full_name,
      DOB: DOB,
    }),
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
  }).catch((e) => {
    console.log(e);
  });
}
