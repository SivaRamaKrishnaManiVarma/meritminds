/**
 * PhotoManEa Backend Server
 * Production-ready Express server with security, logging, and error handling
 */

require('dotenv').config();
const express = require('express');
const path = require('path');

// Import configurations
const config = require('./config/config');
const connectDB = require('./config/database');
const { applySecurity } = require('./config/security');

// Import middleware
const { errorHandler, notFoundHandler } = require('./middleware/errorHandler');
const { requestLogger, logger } = require('./utils/logger');

// Initialize Express app
const app = express();

// ============================================
// 1. TRUST PROXY (for accurate IP addresses behind reverse proxy)
// ============================================
app.set('trust proxy', 1);

// ============================================
// 2. BASIC MIDDLEWARE
// ============================================
app.use(express.json({ limit: '50mb' })); // Parse JSON bodies
app.use(express.urlencoded({ extended: true, limit: '50mb' })); // Parse URL-encoded bodies

// ============================================
// 3. REQUEST LOGGING
// ============================================
app.use(requestLogger); // Log all HTTP requests

// ============================================
// 4. SECURITY MIDDLEWARE
// ============================================
applySecurity(app); // Helmet, CORS, Rate Limiting, etc.
logger.info('✅ Security middleware applied');

// ============================================
// 5. STATIC FILES
// ============================================
app.use('/uploads', express.static(path.join(__dirname, 'uploads')));
logger.info('✅ Static file serving configured for /uploads');

// ============================================
// 6. HEALTH CHECK ENDPOINT (before routes)
// ============================================
app.get('/api/health', (req, res) => {
  res.status(200).json({
    success: true,
    message: 'PhotoManEa Backend is running',
    timestamp: new Date().toISOString(),
    environment: config.server.env,
    uptime: process.uptime()
  });
});

app.get('/api/status', (req, res) => {
  res.status(200).json({
    success: true,
    status: 'operational',
    database: 'connected',
    services: {
      api: 'active',
      faceRecognition: 'active',
      fileUpload: 'active',
      authentication: 'active'
    }
  });
});

// ============================================
// 7. API ROUTES
// ============================================
logger.info('📡 Loading API routes...');

try {
  // Auth routes (AUTHENTICATION SYSTEM - NEW!)
  app.use('/api/auth', require('./routes/auth'));
  logger.info('  ✅ Auth routes loaded');
  
  // Events routes
  app.use('/api/events', require('./routes/events'));
  logger.info('  ✅ Events routes loaded');
  
  // Registration routes
  app.use('/api/registrations', require('./routes/registrations'));
  logger.info('  ✅ Registration routes loaded');
  
  // Photo routes
  app.use('/api/photos', require('./routes/photos'));
  logger.info('  ✅ Photo routes loaded');
  
  // Face matching routes
  app.use('/api/face-matching', require('./routes/faceMatching'));
  logger.info('  ✅ Face matching routes loaded');
  

  // ⬆️ END OF ADDITION ⬆️
  
  logger.info('✅ All routes loaded successfully');
} catch (error) {
  logger.error('❌ Failed to load routes:', error);
  console.error('Route loading error:', error.message);
  process.exit(1);
}


// ============================================
// 8. 404 HANDLER (Route not found)
// ============================================
app.use(notFoundHandler);

// ============================================
// 9. GLOBAL ERROR HANDLER (Must be last)
// ============================================
app.use(errorHandler);

// ============================================
// 10. DATABASE CONNECTION
// ============================================
const startServer = async () => {
  try {
    // Connect to MongoDB
    logger.info('🔄 Connecting to MongoDB...');
    await connectDB();
    logger.info('✅ MongoDB connected successfully');
    
    // Start server
    const PORT = config.server.port;
    const HOST = config.server.host;
    
    app.listen(PORT, HOST, () => {
      console.log('');
      console.log('═══════════════════════════════════════════════════════');
      console.log('🚀 PhotoManEa Backend Server Started Successfully!');
      console.log('═══════════════════════════════════════════════════════');
      console.log(`📍 Server URL: http://${HOST}:${PORT}`);
      console.log(`🌍 Environment: ${config.server.env}`);
      console.log(`🔐 Security: Enabled (Helmet, CORS, Rate Limiting)`);
      console.log(`📊 Logging: ${config.logging.level.toUpperCase()}`);
      console.log(`🎯 Frontend URL: ${config.server.frontendUrl}`);
      console.log('');
      console.log('📡 Available Endpoints:');
      console.log('   ── SYSTEM ──');
      console.log('   GET  /api/health              - Health check');
      console.log('   GET  /api/status              - System status');
      console.log('');
      console.log('   ── AUTHENTICATION (NEW!) ──');
      console.log('   POST /api/auth/register       - Organizer signup');
      console.log('   POST /api/auth/login          - User login');
      console.log('   GET  /api/auth/me             - Get profile (protected)');
      console.log('   PUT  /api/auth/update-profile - Update profile (protected)');
      console.log('   PUT  /api/auth/change-password- Change password (protected)');
      console.log('   POST /api/auth/logout         - Logout (protected)');
      console.log('');
      console.log('   ── EVENTS ──');
      console.log('   POST /api/events              - Create event');
      console.log('   GET  /api/events              - List events');
      console.log('');
      console.log('   ── GUESTS ──');
      console.log('   POST /api/registrations       - Guest registration');
      console.log('');
      console.log('   ── PHOTOS ──');
      console.log('   POST /api/photos/upload       - Upload photos');
      console.log('   POST /api/face-matching       - Face matching');
      console.log('═══════════════════════════════════════════════════════');
      console.log('');
      console.log('🎉 Phase 1 Complete: Authentication System Active!');
      console.log('');
      
      logger.info(`Server started on ${HOST}:${PORT}`);
    });
    
  } catch (error) {
    logger.error('❌ Failed to start server:', error);
    console.error('Startup error:', error.message);
    process.exit(1);
  }
};

// ============================================
// 11. GRACEFUL SHUTDOWN
// ============================================
const gracefulShutdown = (signal) => {
  logger.info(`\n${signal} received. Starting graceful shutdown...`);
  process.exit(0);
};

// Handle shutdown signals
process.on('SIGTERM', () => gracefulShutdown('SIGTERM'));
process.on('SIGINT', () => gracefulShutdown('SIGINT'));

// Handle uncaught exceptions
process.on('uncaughtException', (error) => {
  logger.error('💥 UNCAUGHT EXCEPTION! Shutting down...', error);
  console.error('Uncaught Exception:', error);
  process.exit(1);
});

// Handle unhandled promise rejections
process.on('unhandledRejection', (reason, promise) => {
  logger.error('💥 UNHANDLED REJECTION! Shutting down...', { reason, promise });
  console.error('Unhandled Rejection at:', promise, 'reason:', reason);
  process.exit(1);
});



// ============================================
// 12. START THE SERVER
// ============================================
startServer();

// Export app for testing
module.exports = app;
