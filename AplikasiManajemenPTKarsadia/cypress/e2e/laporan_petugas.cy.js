describe("Testing Fitur Laporan Petugas", () => {
  const usernamePetugas = "udin";
  const passwordPetugas = "123";

  const judulLaporan = "Laporan Perawatan Tanaman Melon";
  const namaPetugas = "Udin";
  const tanggalLaporan = "2026-06-16";

  const catatanLaporan =
    "Tanaman melon telah diperiksa dan dilakukan perawatan rutin pada area greenhouse.";

  before(() => {
    // Membuat gambar dummy agar selectFile tidak error
    const gambarDummy =
      "iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII=";

    cy.writeFile("cypress/fixtures/laporan.png", gambarDummy, "base64");
  });

  beforeEach(() => {
    cy.clearCookies();
    cy.clearLocalStorage();
  });

  function bukaHalamanLaporanPetugas() {
    cy.login(usernamePetugas, passwordPetugas);

    cy.visit("/laporan");

    cy.contains("Laporan", { timeout: 10000 }).should("be.visible");
  }

  function bukaModalTambahLaporan() {
    cy.get("body").then(($body) => {
      if ($body.find('[data-bs-target="#modalTambahLaporan"]').length > 0) {
        cy.get('[data-bs-target="#modalTambahLaporan"]')
          .first()
          .click({ force: true });
      } else {
        cy.contains("Tambah")
          .should("be.visible")
          .click({ force: true });
      }
    });

    cy.showModalIfHidden("#modalTambahLaporan");

    cy.get("#modalTambahLaporan").should("be.visible");
  }

  function isiFormTambahLaporan() {
    cy.get('#modalTambahLaporan input[name="judul_laporan"]')
      .should("be.visible")
      .clear({ force: true })
      .type(judulLaporan, { force: true });

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
      .type(catatanLaporan, { force: true });

    cy.get("body").then(($body) => {
      if ($body.find('#modalTambahLaporan input[type="file"]').length > 0) {
        cy.get('#modalTambahLaporan input[type="file"]')
          .selectFile("cypress/fixtures/laporan.png", { force: true });
      }
    });
  }

  it("TC.LAPORAN.PETUGAS.001.001 - Petugas dapat membuka halaman laporan", () => {
    bukaHalamanLaporanPetugas();

    cy.location("pathname").should("include", "/laporan");
    cy.contains("Laporan").should("be.visible");
  });

  it("TC.LAPORAN.PETUGAS.002.001 - Petugas dapat menambahkan laporan dengan data valid", () => {
    bukaHalamanLaporanPetugas();

    bukaModalTambahLaporan();

    isiFormTambahLaporan();

    cy.get('#modalTambahLaporan button[type="submit"]')
      .click({ force: true });

    cy.contains(judulLaporan, { timeout: 10000 }).should("be.visible");
  });

  it("TC.LAPORAN.PETUGAS.002.002 - Petugas tidak dapat menambahkan laporan dengan field wajib kosong", () => {
    bukaHalamanLaporanPetugas();

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

    cy.get('#modalTambahLaporan select[name="id_greenhouse"]').then(($select) => {
      if ($select.find('option[value=""]').length > 0) {
        cy.wrap($select)
          .select("", { force: true })
          .should("have.value", "");
      }
    });

    cy.get('#modalTambahLaporan select[name="aktivitas"]').then(($select) => {
      if ($select.find('option[value=""]').length > 0) {
        cy.wrap($select)
          .select("", { force: true })
          .should("have.value", "");
      }
    });

    cy.get('#modalTambahLaporan button[type="submit"]')
      .click({ force: true });

    cy.get('#modalTambahLaporan input[name="judul_laporan"]').then(($input) => {
      expect($input[0].checkValidity()).to.eq(false);
    });

    cy.get("#modalTambahLaporan").should("be.visible");
  });

  it("TC.LAPORAN.PETUGAS.003.002 - Petugas tidak dapat mengedit dan menghapus laporan", () => {
    bukaHalamanLaporanPetugas();

    cy.contains("Laporan").should("be.visible");

    cy.get(".edit-btn").should("not.exist");
    cy.get(".open-hapus-modal").should("not.exist");

    cy.contains("Tambah").should("be.visible");
  });
});