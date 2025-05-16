function setCookie(name, value, days) {
  var expires = "";
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

//mekanisme dark/light mode
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

//mekenisme pencarian
$(document).ready(function () {
  $("#live-search").on("keyup", function () {
    let keyword = $(this).val();
    if (keyword.length >= 1) {
      $.ajax({
        url: "controllers/search.php",
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

  //mekanisme filter
  $("#sort-filter").on("change", function () {
    var sortBy = $(this).val();

    $.ajax({
      url: "./controllers/sort.php",
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

//mekanisme tambah/edit/buy produk
$(document).ready(function () {
  $("#addButton").click(function () {
    $("#modalTitle").text("Tambah Produk");
    $("#productForm").attr("action", "controllers/insert.php");

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
    $("#productForm").attr("action", "controllers/update.php");

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
    $("#buyForm").attr("action", "controllers/payment.php");
  });

  $("#closeBuyModal").click(function () {
    $("#buyModal").addClass("hidden");
  });
});

// mekanisme banner
document.addEventListener("DOMContentLoaded", function () {
  const banners = document.querySelectorAll(".banner");
  if (banners.length === 0) return;

  let currentIndex = 0;

  banners.forEach((banner) => {
    banner.classList.add("hidden", "opacity-0");
    banner.classList.remove("opacity-100");
  });

  banners[currentIndex].classList.remove("hidden");

  setTimeout(() => {
    banners[currentIndex].classList.add("opacity-100");
    banners[currentIndex].classList.remove("opacity-0");
  }, 50);

  function rotateToNextBanner() {
    banners[currentIndex].classList.remove("opacity-100");
    banners[currentIndex].classList.add("opacity-0");

    setTimeout(() => {
      banners[currentIndex].classList.add("hidden");
      currentIndex = (currentIndex + 1) % banners.length;

      banners[currentIndex].classList.remove("hidden");

      setTimeout(() => {
        banners[currentIndex].classList.remove("opacity-0");
        banners[currentIndex].classList.add("opacity-100");
      }, 50);
    }, 500);
  }

  setInterval(rotateToNextBanner, 4000);
});

//mekanisme menghapus message
$(document).ready(function () {
  $("#messageOk").click(function () {
    $("#messageModal").addClass("hidden");
    $.post("controllers/clearMessage.php");
  });
});

//mekanisme pesan konfirmasi
function showConfirmModal(message, onConfirm) {
  $("#confirmMessage").text(message);

  $("#confirmModal").removeClass("hidden");

  $("#okConfirm")
    .off("click")
    .on("click", function () {
      $("#confirmModal").addClass("hidden");
      if (typeof onConfirm === "function") {
        onConfirm();
      }
    });

  $("#cancelConfirm")
    .off("click")
    .on("click", function () {
      $("#confirmModal").addClass("hidden");
    });
}

$(document).ready(function () {
  $("#logoutButton").on("click", function (e) {
    e.preventDefault();
    showConfirmModal("Apakah anda yakin ingin logout?", function () {
      window.location.href = "controllers/logout.php";
    });
  });
});

$(document).on("click", ".deleteButton", function () {
  let item = $(this).data("item");
  const id = item.id;
  showConfirmModal("Apakah anda yakin akan menghapus produk ini?", function () {
    window.location.href = `controllers/delete.php?id=${id}`;
  });
});
