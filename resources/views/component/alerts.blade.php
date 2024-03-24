@if (session()->has('success'))
    <script>
        Swal.fire({
            title: "Berhasil",
            text: "{{ session('success') }}",
            icon: "success"
        });
    </script>
@endif
@if (session()->has('error'))
    <script>
        Swal.fire({
            title: "Gagal",
            text: "{{ session('error') }}",
            icon: "error"
        });
    </script>
@endif
@if (session()->has('confirm'))
    <script>
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success"
                });
            }
        });
    </script>
@endif
