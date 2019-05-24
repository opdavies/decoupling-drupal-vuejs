<template>
  <div id="app" class="min-h-screen font-sans bg-white text-black">
    <div id="nav">
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </div>
    <router-view/>
  </div>
</template>

<style src="./css/app.css"></style>
