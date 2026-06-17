describe("Testing Fitur Laporan Admin", () => {
  const judulLaporan = "Laporan Perawatan Tanaman Melon";
  const judulEdit = "Laporan Pemeriksaan Tanaman Melon";
  const judulHapus = "Laporan Kondisi Greenhouse";
  const namaPetugas = "Admin";
  const tanggalLaporan = "2026-06-16";

  const catatanTambah =
    "Tanaman melon telah diperiksa dan dilakukan perawatan rutin pada area greenhouse.";

  const catatanEdit =
    "Pemeriksaan tanaman telah dilakukan dan kondisi tanaman terlihat cukup baik.";

  const catatanHapus =
    "Laporan ini digunakan untuk memastikan proses hapus data berjalan sesuai kebutuhan.";

  beforeEach(() => {
    cy.clearCookies();
    cy.clearLocalStorage();
  });

  function bukaHalamanLaporan() {
    cy.login("admin", "admin123");
    cy.visit("/laporan");
    cy.contains("Laporan", { timeout: 10000 }).should("be.visible");
  }

  function bukaModalTambahLaporan() {
    cy.contains("Tambah").should("be.visible").click({ force: true });

    cy.showModalIfHidden("#modalTambahLaporan");

    cy.get("#modalTambahLaporan").should("be.visible");
  }

  function isiFormTambahLaporan(judul, catatan) {
    cy.get('#modalTambahLaporan input[name="judul_laporan"]')
      .should("be.visible")
      .clear({ force: true })
      .type(judul, { force: true });

    cy.get('#modalTambahLaporan input[name="tanggal_laporan"]')
      .clear({ force: true })
      .type(tanggalLaporan, { force: true });

    cy.get('#modalTambahLaporan select[name="id_greenhouse"]')
      .select(1, { force: true });

    cy.get('#modalTambahLaporan input[name="nama_petugas"]')
      .clear({ force: true })
      .type(namaPetugas, { force: true });

    cy.get('#modalTambahLaporan select[name="aktivitas"]')
      .select(1, { force: true });

    cy.get('#modalTambahLaporan textarea[name="catatan"]')
      .clear({ force: true })
      .type(catatan, { force: true });

    cy.get("body").then(($body) => {
      if ($body.find('#modalTambahLaporan input[type="file"]').length > 0) {
        cy.get('#modalTambahLaporan input[type="file"]')
          .selectFile("cypress/fixtures/laporan.png", { force: true });
      }
    });
  }

  function tambahLaporan(judul, catatan) {
    bukaModalTambahLaporan();
    isiFormTambahLaporan(judul, catatan);

    cy.get('#modalTambahLaporan button[type="submit"]')
      .click({ force: true });

    cy.contains(judul, { timeout: 10000 }).should("be.visible");
  }

  it("TC.LAPORAN.001.001 - Admin dapat membuka halaman laporan", () => {
    bukaHalamanLaporan();

    cy.location("pathname").should("include", "/laporan");
    cy.contains("Laporan").should("be.visible");
    cy.contains("Tambah").should("be.visible");
  });

  it("TC.LAPORAN.001.002 - User tidak dapat membuka halaman laporan tanpa login", () => {
    cy.visit("/laporan", {
      failOnStatusCode: false,
    });

    cy.location("pathname", { timeout: 10000 }).should("include", "/login");
    cy.get('input[name="username"]').should("be.visible");
    cy.get('input[name="password"], input#password').should("be.visible");
  });

  it("TC.LAPORAN.002.001 - Admin dapat menambahkan laporan dengan data valid", () => {
    bukaHalamanLaporan();

    tambahLaporan(judulLaporan, catatanTambah);
  });

  it("TC.LAPORAN.002.002 - Admin tidak dapat menambahkan laporan dengan field wajib kosong", () => {
    bukaHalamanLaporan();

    bukaModalTambahLaporan();

    cy.get('#modalTambahLaporan input[name="judul_laporan"]')
      .invoke("val", "")
      .trigger("input")
      .trigger("change")
      .should("have.value", "");

    cy.get('#modalTambahLaporan input[name="tanggal_laporan"]')
      .invoke("val", "")
      .trigger("input")
      .trigger("change")
      .should("have.value", "");

    cy.get('#modalTambahLaporan input[name="nama_petugas"]')
      .invoke("val", "")
      .trigger("input")
      .trigger("change")
      .should("have.value", "");

    cy.get('#modalTambahLaporan textarea[name="catatan"]')
      .invoke("val", "")
      .trigger("input")
      .trigger("change")
      .should("have.value", "");

    cy.get('#modalTambahLaporan button[type="submit"]')
      .click({ force: true });

    cy.get('#modalTambahLaporan input[name="judul_laporan"]').then(($input) => {
      expect($input[0].checkValidity()).to.eq(false);
    });

    cy.get("#modalTambahLaporan").should("be.visible");
  });

  it("TC.LAPORAN.003.001 - Admin dapat mengubah laporan dengan data valid", () => {
    bukaHalamanLaporan();

    tambahLaporan(judulLaporan, catatanTambah);

    cy.get(".edit-btn")
      .first()
      .scrollIntoView()
      .click({ force: true });

    cy.showModalIfHidden("#modalEditLaporan");

    cy.get("#modalEditLaporan").should("be.visible");

    cy.get("#editJudul")
      .clear({ force: true })
      .type(judulEdit, { force: true });

    cy.get("#editTanggal")
      .clear({ force: true })
      .type(tanggalLaporan, { force: true });

    cy.get("#editPetugas")
      .clear({ force: true })
      .type(namaPetugas, { force: true });

    cy.get("#editAktivitas")
      .select(1, { force: true });

    cy.get("#editCatatan")
      .clear({ force: true })
      .type(catatanEdit, { force: true });

    cy.get("body").then(($body) => {
      if ($body.find('#modalEditLaporan input[type="file"]').length > 0) {
        cy.get('#modalEditLaporan input[type="file"]')
          .selectFile("cypress/fixtures/laporan.png", { force: true });
      }
    });

    cy.get('#modalEditLaporan button[type="submit"]')
      .click({ force: true });

    cy.contains(judulEdit, { timeout: 10000 }).should("be.visible");
  });

  it("TC.LAPORAN.003.002 - Admin tidak dapat mengubah laporan dengan field wajib kosong", () => {
    bukaHalamanLaporan();

    tambahLaporan(judulLaporan, catatanTambah);

    cy.get(".edit-btn")
      .first()
      .scrollIntoView()
      .click({ force: true });

    cy.showModalIfHidden("#modalEditLaporan");

    cy.get("#modalEditLaporan").should("be.visible");

    cy.get("#editJudul")
      .invoke("val", "")
      .trigger("input")
      .trigger("change")
      .should("have.value", "");

    cy.get("#editTanggal")
      .invoke("val", "")
      .trigger("input")
      .trigger("change")
      .should("have.value", "");

    cy.get("#editPetugas")
      .invoke("val", "")
      .trigger("input")
      .trigger("change")
      .should("have.value", "");

    cy.get("#editCatatan")
      .invoke("val", "")
      .trigger("input")
      .trigger("change")
      .should("have.value", "");

    cy.get('#modalEditLaporan button[type="submit"]')
      .click({ force: true });

    cy.get("#editJudul").then(($input) => {
      expect($input[0].checkValidity()).to.eq(false);
    });

    cy.get("#modalEditLaporan").should("be.visible");
  });

    it("TC.LAPORAN.004.001 - Admin dapat menghapus laporan", () => {
    bukaHalamanLaporan();

    cy.get(".open-hapus-modal")
        .should("exist");

    cy.get(".open-hapus-modal")
        .first()
        .scrollIntoView()
        .click({ force: true });

    cy.showModalIfHidden("#modalHapusLaporan");

    cy.get("#modalHapusLaporan")
        .should("be.visible");

    cy.get('#modalHapusLaporan button[type="submit"]')
        .click({ force: true });

    cy.contains("Laporan", { timeout: 10000 })
        .should("be.visible");
    });

    it("TC.LAPORAN.004.002 - Admin membatalkan proses hapus laporan", () => {
    bukaHalamanLaporan();

    // Pastikan ada data laporan dan tombol hapus tersedia
    cy.get(".open-hapus-modal")
        .should("exist");

    // Ambil judul laporan pertama sebelum proses hapus dibatalkan
    cy.get(".gh-card")
        .first()
        .find(".nama-gh")
        .invoke("text")
        .then((judulLaporan) => {
        const judul = judulLaporan.trim();

        // Klik tombol hapus pada data laporan pertama
        cy.get(".gh-card")
            .first()
            .within(() => {
            cy.get(".open-hapus-modal")
                .scrollIntoView()
                .click({ force: true });
            });

        cy.showModalIfHidden("#modalHapusLaporan");

        cy.get("#modalHapusLaporan")
            .should("be.visible");

        // Klik tombol batal
        cy.get("#modalHapusLaporan")
            .contains("button", "Batal")
            .click({ force: true });

        // Pastikan data laporan tetap ada karena proses hapus dibatalkan
        cy.contains(judul)
            .should("be.visible");
        });
    });
});