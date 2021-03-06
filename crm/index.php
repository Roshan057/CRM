<?php include('connection.php'); ?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
  <title>Company Management System</title>
  <style type="text/css">
    .btnAdd {
      text-align: right;
      width: 83%;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <h2 class="text-center">Companies</h2>
    <p class="datatable design text-center">Welcome to Datatable</p>
    <div class="row">
      <div class="container">
        <div class="btnAdd">
          <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addcompanyModal" class="btn btn-success btn-sm">Add</a>
        </div>
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <table id="example" class="table">
              <thead>
                <th>Name</th>
                <th>Website</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Country</th>
                <th>Industry </th>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div class="col-md-2"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
  <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="js/dt-1.10.25datatables.min.js"></script>
  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
  -->
  <script type="text/javascript">
    $(document).ready(function() {
      $('#example').DataTable({
        "fnCreatedRow": function(nRow, aData, iDataIndex) {
          $(nRow).attr('id', aData[0]);
        },
        'serverSide': 'true',
        'processing': 'true',
        'paging': 'true',
        'order': [],
        'ajax': {
          'url': 'fetch_data.php',
          'type': 'post',
        },
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [5]
          },

        ]
      });
    });
    $(document).on('submit', '#addCompanyModal', function(e) {
      e.preventDefault();
      var City = $('#addCityField').val();
      var Country = $('#addCountryField').val();
      var Name = $('#addNameField').val();
      var PhoneNumber = $('#addPhoneNumberField').val();
      var Website = $('#addWebsiteField').val();
      var Address = $('#addAddressField').val();
      var State = $('#addStateField').val();
      var Industry = $('#addIndustryField').val();
      if (City != '' && Country != '' && Name != '' && PhoneNumber != ''  && Website != '' && Address != '' && State != '' && Industry != '') {
        $.ajax({
          url: "add_user.php",
          type: "post",
          data: {
            City: City,
            Name: Name,
            PhoneNumber:PhoneNumber,
            Website:Website,
            Country:Country,
            State:State,
            Industry:Industry,
            Address:Address
          },
          success: function(data) {
            var json = JSON.parse(data);
            var status = json.status;
            if (status == 'true') {
              mytable = $('#example').DataTable();
              mytable.draw();
              $('#addCompanyModal').modal('hide');
            } else {
              alert('failed');
            }
          }
        });
      } else {
        alert('Fill all the required fields');
      }
    });
    $(document).on('submit', '#updateUser', function(e) {
      e.preventDefault();
      //var tr = $(this).closest('tr');
      var City = $('#addCityField').val();
      var Country = $('#addCountryField').val();
      var Name = $('#addNameField').val();
      var PhoneNumber = $('#addPhoneNumberField').val();
      var Website = $('#addWebsiteField').val();
      var Address = $('#addAddressField').val();
      var State = $('#addStateField').val();
      var Industry = $('#addIndustryField').val();
      if (City != '' && Country != '' && Name != '' && PhoneNumber != ''  && Website != '' && Address != '' && State != '' && Industry != '') {
        $.ajax({
          url: "update_user.php",
          type: "post",
          data: {
            City: City,
            Name: Name,
            PhoneNumber:PhoneNumber,
            Website:Website,
            Country:Country,
            State:State,
            Industry:Industry,
            Address:Address
          },
          success: function(data) {
            var json = JSON.parse(data);
            var status = json.status;
            if (status == 'true') {
              table = $('#example').DataTable();
              var button = '<td><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Edit</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtn">Delete</a></td>';
              var row = table.row("[id='" + trid + "']");
              row.row("[id='" + trid + "']").data([Name,Website,PhoneNumber,Address,City,State,Country,Industry,button]);
              $('#exampleModal').modal('hide');
            } else {
              alert('failed');
            }
          }
        });
      } else {
        alert('Fill all the required fields');
      }
    });
    $('#example').on('click', '.editbtn ', function(event) {
      var table = $('#example').DataTable();
      var trid = $(this).closest('tr').attr('id');
      // console.log(selectedRow);
      var id = $(this).data('id');
      $('#exampleModal').modal('show');

      $.ajax({
        url: "get_single_data.php",
        data: {
          id: id
        },
        type: 'post',
        success: function(data) {
          var json = JSON.parse(data);
          $('#NameField').val(json.Name);
          $('#PhoneNumberField').val(json.PhoneNumber);
          $('#AddressField').val(json.Address);
          $('#WebsiteField').val(json.Website);
          $('#CityField').val(json.City);
          $('#StateField').val(json.State);
          $('#CountryField').val(json.Country);
          $('#IndustryField').val(json.Industry);
          $('#trid').val(trid);
        }
      })
    });

    $(document).on('click', '.deleteBtn', function(event) {
      var table = $('#example').DataTable();
      event.preventDefault();
      var id = $(this).data('id');
      if (confirm("Are you sure want to delete this Company ? ")) {
        $.ajax({
          url: "delete_user.php",
          data: {
            id: id
          },
          type: "post",
          success: function(data) {
            var json = JSON.parse(data);
            status = json.status;
            if (status == 'success') {
              //table.fnDeleteRow( table.$('#' + id)[0] );
              //$("#example tbody").find(id).remove();
              //table.row($(this).closest("tr")) .remove();
              $("#" + Name).closest('tr').remove();
            } else {
              alert('Failed');
              return;
            }
          }
        });
      } else {
        return null;
      }



    })
  </script>
  <!-- Modal -->
  <div class="modal fade" id="addcompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Company</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="updateCompany">
            <input type="hidden" name="id" id="id" value="">
            <input type="hidden" name="trid" id="trid" value="">
            <div class="mb-3 row">
              <label for="nameField" class="col-md-3 form-label">Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="nameField" name="name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="websiteField" class="col-md-3 form-label">Website</label>
              <div class="col-md-9">
                <input type="url" class="form-control" id="WebsiteField" name="Website">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="PhoneField" class="col-md-3 form-label">PhoneNumber</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="PhoneField" name="PhoneNumber">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="AddressField" class="col-md-3 form-label">Address</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="AddressField" name="Address">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="cityField" class="col-md-3 form-label">City</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="cityField" name="City">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="StateField" class="col-md-3 form-label">State</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="StateField" name="State">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="CountryField" class="col-md-3 form-label">Country</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="CountryField" name="Country">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="IndustryField" class="col-md-3 form-label">Industry</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="IndustryField" name="Industry" list=IndustryName>
                <datalist id="IndustryField">
                  <option value="Account">
                  <option value="IT">
                  <option value="Sales">
                  <option value="Healthcare">
                </datalist>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Add user Modal -->
  <div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addCompany" action="">
          <div class="mb-3 row">
              <label for="nameField" class="col-md-3 form-label">Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="nameField" name="name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="websiteField" class="col-md-3 form-label">Website</label>
              <div class="col-md-9">
                <input type="url" class="form-control" id="WebsiteField" name="Website">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="PhoneField" class="col-md-3 form-label">PhoneNumber</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="PhoneField" name="PhoneNumber">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="AddressField" class="col-md-3 form-label">Address</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="AddressField" name="Address">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="cityField" class="col-md-3 form-label">City</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="cityField" name="City">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="StateField" class="col-md-3 form-label">State</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="StateField" name="State">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="CountryField" class="col-md-3 form-label">Country</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="CountryField" name="Country">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="IndustryField" class="col-md-3 form-label">Industry</label>
              <div class="col-md-9">
                <input type="text" class="form-control" id="IndustryField" name="Industry" list=IndustryName>
                <datalist id="IndustryField">
                  <option value="Account">
                  <option value="IT">
                  <option value="Sales">
                  <option value="Healthcare">
                </datalist>
              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
<script type="text/javascript">
  //var table = $('#example').DataTable();
</script>