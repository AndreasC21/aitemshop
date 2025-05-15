function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

$(document).ready(function () {
  $("#to-dark-icon").click(function () {
    $("body").addClass("dark");
    $(".background-item").addClass("dark");
    $("#sort-filter").addClass("dark");
    $("#other-opt").addClass("dark");
    setCookie("theme", "dark", 30);
    $("#to-dark-icon").hide();
    $("#to-light-icon").show();
  });

  $("#to-light-icon").click(function () {
    $("body").removeClass("dark");
    $(".background-item").removeClass("dark");
    $("#sort-filter").removeClass("dark");
    $("#other-opt").removeClass("dark");
    setCookie("theme", "light", 30);
    $("#to-light-icon").hide();
    $("#to-dark-icon").show();
  });
});

$(document).ready(function () {
  $("#live-search").on("keyup", function () {
    let keyword = $(this).val();
    if (keyword.length >= 1) {
      $.ajax({
        url: "/search.php",
        method: "GET",
        data: { keyword: keyword },
        success: function (data) {
          $("#live-search-result").html(data);
          $("#search-results-dropdown").removeClass("hidden");
        },
      });
    } else {
      $("#live-search-result").html("");
      $("#search-results-dropdown").addClass("hidden");
    }
  });

  $(document).on("click", function (e) {
    if (
      !$(e.target).closest("#live-search").length &&
      !$(e.target).closest("#search-results-dropdown").length
    ) {
      $("#search-results-dropdown").addClass("hidden");
    }
  });

  $("#live-search").on("focus", function () {
    if ($("#live-search-result").html().trim() !== "") {
      $("#search-results-dropdown").removeClass("hidden");
    }
  });

  $("#sort-filter").on("change", function () {
    var sortBy = $(this).val();

    $.ajax({
      url: "/api/controllers/sort.php",
      type: "GET",
      data: { sort: sortBy },
      success: function (data) {
        $("#product-list").html(data);
      },
      error: function () {
        alert("Gagal memuat produk yang diurutkan.");
      },
    });
  });
});

$(document).ready(function () {
  $("#addButton").click(function () {
    $("#modalTitle").text("Tambah Produk");
    $("#productForm").attr("action", "/api/controllers/insert.php");

    $("#productId").val("");
    $("#oldImg").val("");
    $("#productName").val("");
    $("#productPrice").val("");
    $("#productStock").val("");
    $("#productImg").val("");

    $("#productModal").removeClass("hidden");
  });

  $(document).on("click", ".editButton", function () {
    let item = $(this).data("item");

    $("#modalTitle").text("Edit Produk");
    $("#productForm").attr("action", "/api/controllers/update.php");

    $("#productId").val(item.id);
    $("#oldImg").val(item.img);
    $("#productName").val(item.name);
    $("#productPrice").val(item.price);
    $("#productStock").val(item.stock);
    $("#productImg").val("");

    $("#productModal").removeClass("hidden");
  });

  $("#closeModal").click(function () {
    $("#productModal").addClass("hidden");
  });

  $(document).on("click", ".buyButton", function () {
    let item = $(this).data("item");

    $("#buyId").val(item.id);
    $("#buyName").html(`${item.name}`);
    $("#buyModal").removeClass("hidden");
    $("#buyForm").attr("action", "/api/controllers/payment.php");
  });

  $("#closeBuyModal").click(function () {
    $("#buyModal").addClass("hidden");
  });
});

//mekanisme banner
document.addEventListener("DOMContentLoaded", function () {
  const banners = document.querySelectorAll(".banner");
  let currentIndex = 0;

  banners[currentIndex].classList.remove("opacity-0");
  banners[currentIndex].classList.add("opacity-100");

  setInterval(() => {
    banners[currentIndex].classList.remove("opacity-100");
    banners[currentIndex].classList.add("opacity-0");

    currentIndex = (currentIndex + 1) % banners.length;

    banners[currentIndex].classList.remove("opacity-0");
    banners[currentIndex].classList.add("opacity-100");
  }, 4000);
});

//mekanisme modal message
$(document).ready(function () {
  $("#messageOk").click(function () {
    $("#messageModal").addClass("hidden");
    $.post("/api/controllers/clearMessage.php");
  });
});
