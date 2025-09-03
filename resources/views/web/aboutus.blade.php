@extends('layouts.app')

@section('title', 'Join as Service Provider | ConstructKaro')

@section('content')
  <style>
    /* Base styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f8f9fb;
      color: #1c2c3e;
      line-height: 1.6;
    }
    a {
      text-decoration: none;
      color: inherit;
    }

    /* Header */
    header {
      background: #fff;
      padding: 20px 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    header .logo {
      font-size: 24px;
      font-weight: bold;
      color: #f25c05;
    }
    header nav a {
      margin-left: 25px;
      font-weight: 500;
      color: #1c2c3e;
    }
    header nav a:hover {
      color: #f25c05;
    }

    /* Hero Section */
    .hero {
      text-align: center;
      padding: 80px 20px;
      background: linear-gradient(135deg, #f8f9fb, #eef2f7);
    }
    .hero h1 {
      font-size: 42px;
      font-weight: bold;
      margin-bottom: 15px;
    }
    .hero h1 span {
      color: #f25c05;
    }
    .hero p {
      font-size: 18px;
      max-width: 700px;
      margin: 0 auto;
      color: #555;
    }

    /* About section */
    .about-section {
      display: flex;
      align-items: center;
      gap: 40px;
      max-width: 1100px;
      margin: 80px auto;
      padding: 0 20px;
    }
    .about-section img {
      width: 100%;
      max-width: 500px;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }
    .about-content {
      flex: 1;
    }
    .about-content h2 {
      font-size: 32px;
      margin-bottom: 15px;
    }
    .about-content p {
      margin-bottom: 15px;
      color: #444;
    }

    /* Values Section */
    .values {
      background: #fff;
      padding: 60px 20px;
    }
    .values h2 {
      text-align: center;
      font-size: 32px;
      margin-bottom: 40px;
    }
    .values-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      max-width: 1100px;
      margin: 0 auto;
    }
    .value-card {
      background: #f8f9fb;
      border-radius: 12px;
      padding: 25px;
      text-align: center;
      transition: transform 0.3s;
    }
    .value-card:hover {
      transform: translateY(-6px);
    }
    .value-card i {
      font-size: 32px;
      color: #f25c05;
      margin-bottom: 15px;
    }
    .value-card h3 {
      margin-bottom: 10px;
      font-size: 20px;
      color: #1c2c3e;
    }
    .value-card p {
      font-size: 15px;
      color: #555;
    }

    /* CTA Section */
    .cta {
      text-align: center;
      background: #1c2c3e;
      color: #fff;
      padding: 60px 20px;
    }
    .cta h2 {
      font-size: 28px;
      margin-bottom: 15px;
    }
    .cta p {
      margin-bottom: 25px;
      color: #ccc;
    }
    .cta button {
      background: #f25c05;
      color: #fff;
      padding: 14px 28px;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }
    .cta button:hover {
      background: #d94f04;
    }

    /* Footer */
    footer {
      background: #111;
      color: #aaa;
      text-align: center;
      padding: 20px;
      font-size: 14px;
    }
  </style>

  <!-- Hero -->
  <section class="hero">
    <h1>About <span>ConstructKaro</span></h1>
    <p>We are revolutionizing the construction industry by connecting customers with trusted, verified contractors. Our mission is to make construction simple, transparent, and reliable for everyone.</p>
  </section>

  <!-- About Section -->
  <section class="about-section">
    <img src="https://source.unsplash.com/600x400/?construction,building" alt="About ConstructKaro">
    <div class="about-content">
      <h2>Who We Are</h2>
      <p>At ConstructKaro, we bring together homeowners, developers, and verified construction professionals to ensure projects are completed with trust, quality, and efficiency.</p>
      <p>With our innovative platform, customers can easily post projects, compare contractors, and manage their construction journey seamlessly.</p>
    </div>
  </section>

  <!-- Values Section -->
  <section class="values">
    <h2>Our Core Values</h2>
    <div class="values-grid">
      <div class="value-card">
        <i class="fas fa-check-circle"></i>
        <h3>Trust</h3>
        <p>Only verified contractors and vendors to ensure transparency in every project.</p>
      </div>
      <div class="value-card">
        <i class="fas fa-bolt"></i>
        <h3>Efficiency</h3>
        <p>Smart project management tools to save time, money, and effort.</p>
      </div>
      <div class="value-card">
        <i class="fas fa-users"></i>
        <h3>Community</h3>
        <p>Building a strong ecosystem of customers, contractors, and vendors.</p>
      </div>
      <div class="value-card">
        <i class="fas fa-lightbulb"></i>
        <h3>Innovation</h3>
        <p>Leveraging technology to modernize the construction process in India.</p>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta">
    <h2>Ready to Start Building with Us?</h2>
    <p>Join thousands of satisfied customers who trust ConstructKaro for their projects.</p>
    <button>Post a Project</button>
  </section>
@endsection

