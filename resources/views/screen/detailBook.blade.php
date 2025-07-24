<!-- Modal -->
<div class="modal fade" id="detailBukuModal" tabindex="-1" aria-labelledby="detailBukuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="detailBukuModalLabel">Detail Buku</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row">
              <!-- Gambar Buku -->
              <div class="col-md-6 text-center mb-3">
                  <img id="modalGambar" src="" alt="Cover Buku" class="img-fluid shadow rounded" style="height: 300px; object-fit: cover;">
              </div>
  
              <!-- Data Buku sebagai tabel (rata kiri) -->
              <div class="col-md-6">
                  <table class="table table-borderless">
                      <tr>
                          <th class="text-start">Nama Buku</th>
                          <td class="text-start"><span id="modalNama"></span></td>
                      </tr>
                      <tr>
                          <th class="text-start">Pengarang</th>
                          <td class="text-start"><span id="modalPengarang"></span></td>
                      </tr>
                      <tr>
                          <th class="text-start">Penerbit</th>
                          <td class="text-start"><span id="modalPenerbit"></span></td>
                      </tr>
                      <tr>
                          <th class="text-start">Tahun Terbit</th>
                          <td class="text-start"><span id="modalTahun"></span></td>
                      </tr>
                      <tr>
                          <th class="text-start">Kategori</th>
                          <td class="text-start"><span id="modalKategori"></span></td>
                      </tr>
                  </table>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>