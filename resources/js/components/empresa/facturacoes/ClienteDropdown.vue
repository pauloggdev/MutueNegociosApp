<template>
  <div id="cliente-dropdown">
    <div class="cliente-dropdown-content">
      <h1>cadastro cliente</h1>
    </div>
  </div>
</template>

<script>
export default {
  name: "ClienteDropdown"
};
</script>

<style>

.cliente-dropdown-content {
  position: absolute;
  right: 0;
  background-color: #f9f9f9;
  min-width: 170px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  padding: 10px;
  z-index: 99999;
  top: 0;
  position: fixed;
  height: 100%;
}
</style>