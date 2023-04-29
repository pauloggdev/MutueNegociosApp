<script>
  export default {
    methods: {
      $can(permissionName) {

        console.log(window.Laravel);return;
        return Permissions.indexOf(permissionName) !== -1;
      },
    },
  };
</script>