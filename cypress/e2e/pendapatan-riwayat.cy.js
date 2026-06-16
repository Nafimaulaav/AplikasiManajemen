describe('Pengujian Fitur Pendapatan dan Riwayat', () => {

  beforeEach(() => {
  cy.visit('http://127.0.0.1:8000/login')

  cy.get('input:visible').eq(0).type('admin')
  cy.get('input:visible').eq(1).type('admin123')

  cy.contains('button', 'Masuk').click()

  cy.url().should('not.include', '/login')
})

  it('Membuka halaman Pendapatan', () => {
    cy.visit('http://127.0.0.1:8000/pendapatan')

    cy.contains('Laporan Pendapatan').should('be.visible')
    cy.contains('Rekap Transaksi').should('be.visible')
  })

  it('Menampilkan popup Tambah Transaksi', () => {
    cy.visit('http://127.0.0.1:8000/pendapatan')

    cy.contains('Tambah Transaksi').click()

    cy.contains('Tambah Transaksi Baru').should('be.visible')
    cy.contains('ID Transaksi').should('be.visible')
    cy.contains('Tanggal Transaksi').should('be.visible')
    cy.contains('Jumlah Pendapatan').should('be.visible')
    cy.contains('Nama Petugas').should('be.visible')
  })

  it('Membuka halaman Riwayat', () => {
    cy.visit('http://127.0.0.1:8000/riwayat')

    cy.contains('Riwayat Aktivitas').should('be.visible')
  })

  it('Menampilkan tabel Riwayat', () => {
    cy.visit('http://127.0.0.1:8000/riwayat')

    cy.contains('Waktu').should('be.visible')
    cy.contains('Petugas').should('be.visible')
    cy.contains('Aksi').should('be.visible')
    cy.contains('Menu').should('be.visible')
    cy.contains('Deskripsi').should('be.visible')
  })

})