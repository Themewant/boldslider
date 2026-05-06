<?php
/**
 * Built-in template and slide library data.
 *
 * All data is hardcoded here for the free version.
 * To swap to a remote API: replace the bodies of get_templates() and get_slides()
 * with HTTP calls (wp_remote_get) and cache the result with transients.
 *
 * @package BoldSlider
 */

declare(strict_types=1);

namespace BoldSlider\Library;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class LibraryData {

	// ── Public API ────────────────────────────────────────────────────────────

	/** Returns all 15 built-in slider templates. */
	public static function get_templates(): array {
		return [
			self::tpl_hero_dark(),
			self::tpl_hero_light(),
			self::tpl_hero_split(),
			self::tpl_business(),
			self::tpl_portfolio(),
			self::tpl_promo_sale(),
			self::tpl_testimonials(),
			self::tpl_product_launch(),
			self::tpl_team(),
			self::tpl_event(),
			self::tpl_startup(),
			self::tpl_minimal(),
			self::tpl_restaurant(),
			self::tpl_charity(),
			self::tpl_welcome(),
		];
	}

	/** Returns all 20 built-in individual slides. */
	public static function get_slides(): array {
		return [
			self::sl_dark_blue(),
			self::sl_red_impact(),
			self::sl_clean_white(),
			self::sl_charcoal(),
			self::sl_ocean_blue(),
			self::sl_sale_red(),
			self::sl_quote_light(),
			self::sl_stats_dark(),
			self::sl_cta_green(),
			self::sl_event_dark(),
			self::sl_product_blue(),
			self::sl_team_light(),
			self::sl_nature(),
			self::sl_purple_creative(),
			self::sl_warm_amber(),
			self::sl_thank_you(),
			self::sl_minimal_text(),
			self::sl_two_column(),
			self::sl_launch(),
			self::sl_feature_list(),
		];
	}

	// ── Template definitions ──────────────────────────────────────────────────

	private static function tpl_hero_dark(): array {
		return self::tpl(
			'hero-dark',
			'Hero — Dark',
			'Three-slide dark hero carousel with bold animations and CTA buttons.',
			'hero',
			[ '#0f172a', '#3b82f6', '#ffffff' ],
			self::sm(),
			[
				self::slide(
					'#0f172a',
					[
						self::h( 'Welcome to Our World', '#ffffff', 60, 700, 140, 170, 1000, 88, 'h1', 'fade-up', 0.0 ),
						self::bar( 560, 275, 160, 4, '#3b82f6' ),
						self::t( 'Inspiring ideas and powerful solutions for modern teams.', '#94a3b8', 20, 400, 240, 298, 800, 55, 'fade-up', 0.15 ),
						self::btn( 'Get Started', '#3b82f6', '#ffffff', 510, 378, 260, 52, 'arrow-right', 'fade-up', 0.3 ),
					]
				),
				self::slide(
					'#0c1a2e',
					[
						self::img( 680, 50, 540, 500, 'fade', 0.0 ),
						self::h( 'Built for Performance', '#ffffff', 54, 700, 60, 155, 560, 84, 'h2', 'fade-right', 0.0, 'left' ),
						self::bar( 60, 252, 100, 4, '#60a5fa' ),
						self::t( 'Lightning-fast, reliable and scalable for teams of any size.', '#94a3b8', 19, 400, 60, 272, 560, 66, 'fade-right', 0.15, 'left' ),
						self::btn( 'See Features', '#60a5fa', '#0c1a2e', 60, 358, 220, 52, 'arrow-right', 'fade-right', 0.3 ),
					]
				),
				self::slide(
					'#111827',
					[
						self::h( 'Join 50,000+ Happy Users', '#ffffff', 56, 700, 140, 175, 1000, 84, 'h2', 'zoom-in', 0.0 ),
						self::bar( 560, 274, 160, 4, '#3b82f6' ),
						self::t( 'Trusted by startups and enterprises across 90 countries.', '#94a3b8', 20, 400, 240, 295, 800, 55, 'fade-up', 0.2 ),
						self::btn( 'Start Free Trial', '#3b82f6', '#ffffff', 490, 374, 300, 52, 'arrow-right', 'fade-up', 0.35 ),
					]
				),
			]
		);
	}

	private static function tpl_hero_light(): array {
		return self::tpl(
			'hero-light',
			'Hero — Light',
			'Three-slide clean light hero with alternating layouts and animations.',
			'hero',
			[ '#f1f5f9', '#1d4ed8', '#1e293b' ],
			self::sm(),
			[
				self::slide(
					'#f1f5f9',
					[
						self::img( 680, 50, 540, 500, 'fade', 0.0 ),
						self::h( 'Your Success Story Starts Here', '#1e293b', 50, 700, 60, 155, 560, 100, 'h1', 'fade-right', 0.0, 'left' ),
						self::bar( 60, 268, 100, 4, '#1d4ed8' ),
						self::t( 'Professional solutions for modern businesses and growing teams.', '#475569', 19, 400, 60, 288, 560, 66, 'fade-right', 0.2, 'left' ),
						self::btn( 'Learn More', '#1d4ed8', '#ffffff', 60, 374, 220, 52, 'arrow-right', 'fade-right', 0.3 ),
					]
				),
				self::slide(
					'#ffffff',
					[
						self::bar( 80, 175, 4, 250, '#1d4ed8' ),
						self::h( 'Trusted by Industry Leaders', '#1e293b', 52, 800, 112, 178, 780, 78, 'h2', 'fade-right', 0.0, 'left' ),
						self::t( 'Over 10,000 companies rely on us every day to power their operations and grow faster.', '#475569', 19, 400, 112, 272, 720, 80, 'fade-right', 0.15, 'left' ),
						self::btn( 'View Case Studies', '#1d4ed8', '#ffffff', 112, 372, 280, 52, 'external', 'fade-right', 0.3 ),
					]
				),
				self::slide(
					'#eff6ff',
					[
						self::h( 'Ready to Get Started?', '#1e293b', 60, 800, 140, 178, 1000, 90, 'h2', 'zoom-in', 0.0 ),
						self::bar( 560, 280, 160, 4, '#1d4ed8' ),
						self::t( 'No credit card required. Set up in minutes and see results on day one.', '#475569', 20, 400, 240, 300, 800, 55, 'fade-up', 0.2 ),
						self::btn( 'Sign Up Free', '#1d4ed8', '#ffffff', 510, 376, 260, 52, 'arrow-right', 'fade-up', 0.35 ),
					]
				),
			]
		);
	}

	private static function tpl_hero_split(): array {
		return self::tpl(
			'hero-split',
			'Hero — Two Slides',
			'Two-slide hero carousel with contrasting backgrounds.',
			'hero',
			[ '#4c1d95', '#1e40af', '#ffffff' ],
			self::sm(),
			[
				self::slide(
					'#4c1d95',
					[
						self::img( 680, 50, 540, 500, 'fade-left', 0.0 ),
						self::h( 'Build Something Beautiful', '#ffffff', 52, 700, 60, 155, 560, 80, 'h1', 'fade-right', 0.0, 'left' ),
						self::bar( 60, 248, 100, 4, '#e879f9' ),
						self::t( 'Creative tools for creative minds — design without limits.', '#ddd6fe', 19, 400, 60, 268, 560, 66, 'fade-right', 0.15, 'left' ),
						self::btn( 'Start Free', '#e879f9', '#4c1d95', 60, 354, 220, 52, 'arrow-right', 'fade-right', 0.3 ),
					]
				),
				self::slide(
					'#1e40af',
					[
						self::img( 40, 50, 540, 500, 'fade-right', 0.0 ),
						self::h( 'Scale Without Limits', '#ffffff', 52, 700, 660, 155, 560, 80, 'h1', 'fade-left', 0.0, 'left' ),
						self::bar( 660, 248, 100, 4, '#93c5fd' ),
						self::t( 'Powerful infrastructure built for speed, reliability and growth.', '#bfdbfe', 19, 400, 660, 268, 560, 66, 'fade-left', 0.15, 'left' ),
						self::btn( 'Explore Plans', '#ffffff', '#1e40af', 660, 354, 220, 52, 'arrow-right', 'fade-left', 0.3 ),
					]
				),
			]
		);
	}

	private static function tpl_business(): array {
		return self::tpl(
			'business',
			'Business',
			'Three-slide business presentation with corporate blue tones.',
			'business',
			[ '#1d4ed8', '#ffffff', '#dbeafe' ],
			self::sm(),
			[
				self::slide(
					'#1d4ed8',
					[
						self::h( 'We Drive Results', '#ffffff', 60, 700, 140, 175, 1000, 88, 'h1', 'fade-up', 0.0 ),
						self::bar( 560, 278, 160, 4, '#93c5fd' ),
						self::t( 'Data-driven strategies that deliver measurable business growth.', '#bfdbfe', 20, 400, 240, 298, 800, 55, 'fade-up', 0.15 ),
						self::btn( 'Get a Free Quote', '#ffffff', '#1d4ed8', 490, 375, 300, 52, 'arrow-right', 'fade-up', 0.3 ),
					]
				),
				self::slide(
					'#1e40af',
					[
						self::bar( 80, 185, 4, 240, '#93c5fd' ),
						self::h( 'Trusted by 10,000+ Companies', '#ffffff', 50, 700, 112, 185, 800, 78, 'h2', 'fade-right', 0.0, 'left' ),
						self::t( 'From startups to Fortune 500 — we have the expertise you need.', '#bfdbfe', 19, 400, 112, 278, 720, 66, 'fade-right', 0.15, 'left' ),
						self::btn( 'Our Clients', '#ffffff', '#1e40af', 112, 364, 240, 52, 'arrow-right', 'fade-right', 0.3 ),
					]
				),
				self::slide(
					'#1e3a8a',
					[
						self::h( 'Ready to Transform?', '#ffffff', 60, 700, 140, 175, 1000, 88, 'h2', 'fade-up', 0.0 ),
						self::bar( 560, 278, 160, 4, '#93c5fd' ),
						self::t( 'Let\'s build something great together. Book a call today.', '#bfdbfe', 20, 400, 240, 298, 800, 55, 'fade-up', 0.15 ),
						self::btn( 'Book a Call', '#ffffff', '#1e3a8a', 510, 375, 260, 52, 'phone', 'fade-up', 0.3 ),
					]
				),
			]
		);
	}

	private static function tpl_portfolio(): array {
		return self::tpl(
			'portfolio',
			'Portfolio',
			'Dark portfolio showcase with numbered project slides.',
			'portfolio',
			[ '#111827', '#f59e0b', '#f9fafb' ],
			self::sm(),
			[
				self::slide(
					'#111827',
					[
						self::h( '01', '#f59e0b', 90, 800, 80, 110, 260, 130, 'h2', 'fade', 0.0 ),
						self::t( 'BRAND IDENTITY', '#f59e0b', 11, 600, 80, 255, 300, 30, 'fade', 0.1 ),
						self::h( 'Visual Brand Design', '#f9fafb', 52, 700, 80, 293, 700, 78, 'h3', 'fade-up', 0.15 ),
						self::t( 'Crafting identities that resonate with your target audience and stand the test of time.', '#9ca3af', 18, 400, 80, 383, 620, 70, 'fade-up', 0.25 ),
					]
				),
				self::slide(
					'#111827',
					[
						self::h( '02', '#f59e0b', 90, 800, 80, 110, 260, 130, 'h2', 'fade', 0.0 ),
						self::t( 'UI / UX DESIGN', '#f59e0b', 11, 600, 80, 255, 300, 30, 'fade', 0.1 ),
						self::h( 'Digital Experiences', '#f9fafb', 52, 700, 80, 293, 700, 78, 'h3', 'fade-up', 0.15 ),
						self::t( 'Intuitive interfaces that delight users and keep them coming back for more.', '#9ca3af', 18, 400, 80, 383, 620, 70, 'fade-up', 0.25 ),
					]
				),
				self::slide(
					'#111827',
					[
						self::h( '03', '#f59e0b', 90, 800, 80, 110, 260, 130, 'h2', 'fade', 0.0 ),
						self::t( 'DIGITAL STRATEGY', '#f59e0b', 11, 600, 80, 255, 300, 30, 'fade', 0.1 ),
						self::h( 'Growth Marketing', '#f9fafb', 52, 700, 80, 293, 700, 78, 'h3', 'fade-up', 0.15 ),
						self::t( 'Data-backed campaigns that grow your reach and convert visitors into loyal customers.', '#9ca3af', 18, 400, 80, 383, 620, 70, 'fade-up', 0.25 ),
					]
				),
			]
		);
	}

	private static function tpl_promo_sale(): array {
		return self::tpl(
			'promo-sale',
			'Promo / Sale',
			'Eye-catching two-slide sale promotion with bold typography.',
			'promo',
			[ '#dc2626', '#fbbf24', '#ffffff' ],
			self::sm(),
			[
				self::slide(
					'#dc2626',
					[
						self::h( 'BIG SALE', '#ffffff', 96, 900, 80, 130, 1120, 140, 'h1', 'zoom-in', 0.0 ),
						self::h( 'Up to 50% Off Everything', '#fbbf24', 36, 700, 160, 285, 960, 60, 'h2', 'fade-up', 0.2 ),
						self::t( 'Limited time offer — valid this weekend only. Don\'t miss out!', '#fecaca', 18, 400, 240, 358, 800, 48, 'fade', 0.35 ),
						self::btn( 'Shop Now', '#fbbf24', '#dc2626', 510, 422, 260, 52, 'arrow-right', 'fade-up', 0.45 ),
					]
				),
				self::slide(
					'#b91c1c',
					[
						self::h( 'Hurry — Offer Ends Soon', '#ffffff', 54, 700, 140, 195, 1000, 82, 'h2', 'fade-up', 0.0 ),
						self::bar( 560, 290, 160, 4, '#fbbf24' ),
						self::t( 'Use code SALE50 at checkout. Terms and conditions apply.', '#fca5a5', 20, 400, 240, 310, 800, 55, 'fade', 0.15 ),
						self::btn( 'View All Deals', '#fbbf24', '#b91c1c', 510, 380, 260, 52, 'arrow-right', 'fade-up', 0.25 ),
					]
				),
			]
		);
	}

	private static function tpl_testimonials(): array {
		return self::tpl(
			'testimonials',
			'Testimonials',
			'Three customer quote slides on a clean light background.',
			'testimonial',
			[ '#f8fafc', '#3b82f6', '#1e293b' ],
			self::sm(),
			[
				self::slide(
					'#f8fafc',
					[
						self::h( '"', '#3b82f6', 120, 900, 76, 80, 100, 130, 'h2', 'fade', 0.0 ),
						self::h( 'This product transformed the way our entire team collaborates and ships work.', '#1e293b', 28, 600, 140, 160, 1000, 160, 'h2', 'fade-up', 0.1 ),
						self::bar( 140, 334, 60, 3, '#3b82f6' ),
						self::t( 'Sarah Mitchell — CEO, TechFlow Inc.', '#475569', 16, 600, 140, 354, 500, 38, 'fade', 0.25 ),
					]
				),
				self::slide(
					'#f8fafc',
					[
						self::h( '"', '#3b82f6', 120, 900, 76, 80, 100, 130, 'h2', 'fade', 0.0 ),
						self::h( 'Incredible support team and a product that actually does what it promises. Five stars.', '#1e293b', 28, 600, 140, 160, 1000, 160, 'h2', 'fade-up', 0.1 ),
						self::bar( 140, 334, 60, 3, '#3b82f6' ),
						self::t( 'James Harrington — Founder, DesignLab', '#475569', 16, 600, 140, 354, 500, 38, 'fade', 0.25 ),
					]
				),
				self::slide(
					'#f8fafc',
					[
						self::h( '"', '#3b82f6', 120, 900, 76, 80, 100, 130, 'h2', 'fade', 0.0 ),
						self::h( 'We doubled our conversion rate in 90 days. I wish we had found this sooner.', '#1e293b', 28, 600, 140, 160, 1000, 160, 'h2', 'fade-up', 0.1 ),
						self::bar( 140, 334, 60, 3, '#3b82f6' ),
						self::t( 'Priya Sharma — Marketing Director, GrowthHQ', '#475569', 16, 600, 140, 354, 500, 38, 'fade', 0.25 ),
					]
				),
			]
		);
	}

	private static function tpl_product_launch(): array {
		return self::tpl(
			'product-launch',
			'Product Launch',
			'Two-slide product reveal with clean white background.',
			'business',
			[ '#ffffff', '#7c3aed', '#111827' ],
			self::sm(),
			[
				self::slide(
					'#ffffff',
					[
						self::img( 40, 50, 540, 500, 'fade-right', 0.0 ),
						self::t( 'INTRODUCING', '#7c3aed', 12, 700, 660, 158, 560, 28, 'fade', 0.0, 'left' ),
						self::h( 'Your Product Name', '#111827', 52, 800, 660, 192, 560, 82, 'h1', 'fade-left', 0.1, 'left' ),
						self::bar( 660, 287, 80, 4, '#7c3aed' ),
						self::t( 'The smartest way to solve your biggest challenge — built for the future.', '#374151', 19, 400, 660, 307, 560, 70, 'fade-left', 0.25, 'left' ),
						self::btn( 'Get Early Access', '#7c3aed', '#ffffff', 660, 397, 260, 52, 'arrow-right', 'fade-left', 0.4 ),
					]
				),
				self::slide(
					'#faf5ff',
					[
						self::h( 'Why Teams Love It', '#111827', 52, 700, 140, 155, 1000, 78, 'h2', 'fade-up', 0.0 ),
						self::bar( 560, 246, 160, 4, '#7c3aed' ),
						self::t( '✓  10× faster than the competition', '#374151', 20, 400, 240, 270, 800, 44, 'fade-up', 0.1 ),
						self::t( '✓  Works with tools you already use', '#374151', 20, 400, 240, 322, 800, 44, 'fade-up', 0.2 ),
						self::t( '✓  Setup in under 5 minutes, no code needed', '#374151', 20, 400, 240, 374, 800, 44, 'fade-up', 0.3 ),
						self::btn( 'Start Free Trial', '#7c3aed', '#ffffff', 490, 440, 300, 52, 'arrow-right', 'fade-up', 0.45 ),
					]
				),
			]
		);
	}

	private static function tpl_team(): array {
		return self::tpl(
			'team',
			'Team',
			'Dark three-slide team showcase with teal accents.',
			'team',
			[ '#0f172a', '#38bdf8', '#f1f5f9' ],
			self::sm(),
			[
				self::slide(
					'#0f172a',
					[
						self::img( 700, 80, 480, 440, 'fade', 0.0 ),
						self::t( 'CEO &amp; FOUNDER', '#38bdf8', 11, 700, 60, 165, 560, 28, 'fade', 0.0, 'left' ),
						self::h( 'Jane Smith', '#f1f5f9', 58, 700, 60, 198, 560, 84, 'h2', 'fade-right', 0.1, 'left' ),
						self::bar( 60, 295, 80, 3, '#38bdf8' ),
						self::t( '"Passionate about building products that make a real difference in people\'s lives."', '#94a3b8', 18, 400, 60, 313, 560, 110, 'fade-right', 0.25, 'left' ),
					]
				),
				self::slide(
					'#0f172a',
					[
						self::img( 700, 80, 480, 440, 'fade', 0.0 ),
						self::t( 'HEAD OF DESIGN', '#38bdf8', 11, 700, 60, 165, 560, 28, 'fade', 0.0, 'left' ),
						self::h( 'Alex Rivera', '#f1f5f9', 58, 700, 60, 198, 560, 84, 'h2', 'fade-right', 0.1, 'left' ),
						self::bar( 60, 295, 80, 3, '#38bdf8' ),
						self::t( '"Good design is invisible — it just works. I\'m obsessed with getting every detail right."', '#94a3b8', 18, 400, 60, 313, 560, 110, 'fade-right', 0.25, 'left' ),
					]
				),
				self::slide(
					'#0f172a',
					[
						self::img( 700, 80, 480, 440, 'fade', 0.0 ),
						self::t( 'LEAD ENGINEER', '#38bdf8', 11, 700, 60, 165, 560, 28, 'fade', 0.0, 'left' ),
						self::h( 'Sam Chen', '#f1f5f9', 58, 700, 60, 198, 560, 84, 'h2', 'fade-right', 0.1, 'left' ),
						self::bar( 60, 295, 80, 3, '#38bdf8' ),
						self::t( '"Performance, security and reliability — I don\'t believe in choosing just one."', '#94a3b8', 18, 400, 60, 313, 560, 110, 'fade-right', 0.25, 'left' ),
					]
				),
			]
		);
	}

	private static function tpl_event(): array {
		return self::tpl(
			'event',
			'Event',
			'Two-slide event announcement with bold date and registration CTA.',
			'event',
			[ '#18181b', '#facc15', '#fafafa' ],
			self::sm(),
			[
				self::slide(
					'#18181b',
					[
						self::t( 'MARCH 15 – 17, 2025', '#facc15', 13, 700, 140, 155, 1000, 28, 'fade', 0.0 ),
						self::h( 'Annual Design Summit', '#fafafa', 62, 800, 140, 188, 1000, 92, 'h1', 'fade-up', 0.1 ),
						self::bar( 560, 293, 160, 4, '#facc15' ),
						self::t( 'San Francisco Convention Center — 3 days of talks, workshops and networking.', '#a1a1aa', 19, 400, 240, 312, 800, 55, 'fade-up', 0.2 ),
						self::btn( 'Register Now', '#facc15', '#18181b', 510, 388, 260, 52, 'arrow-right', 'fade-up', 0.35 ),
					]
				),
				self::slide(
					'#09090b',
					[
						self::h( 'Join 2,000+ Attendees', '#fafafa', 56, 700, 140, 185, 1000, 84, 'h2', 'fade-up', 0.0 ),
						self::bar( 560, 282, 160, 4, '#facc15' ),
						self::t( '60+ speakers · 40+ workshops · Exclusive networking events', '#a1a1aa', 19, 400, 240, 302, 800, 55, 'fade', 0.2 ),
						self::btn( 'View Schedule', '#facc15', '#09090b', 510, 376, 260, 52, 'external', 'fade-up', 0.35 ),
					]
				),
			]
		);
	}

	private static function tpl_startup(): array {
		return self::tpl(
			'startup',
			'Startup',
			'Dark three-slide carousel with cyan accents for tech startups.',
			'business',
			[ '#020617', '#22d3ee', '#f0fdfa' ],
			self::sm(),
			[
				self::slide(
					'#020617',
					[
						self::h( 'The Future Is Here', '#f0fdfa', 62, 800, 140, 175, 1000, 92, 'h1', 'fade-up', 0.0 ),
						self::bar( 560, 278, 160, 4, '#22d3ee' ),
						self::t( 'AI-powered tools that help your team move 10× faster with half the effort.', '#94a3b8', 20, 400, 240, 298, 800, 55, 'fade-up', 0.15 ),
						self::btn( 'Start Free', '#22d3ee', '#020617', 510, 375, 260, 52, 'arrow-right', 'fade-up', 0.3 ),
					]
				),
				self::slide(
					'#020617',
					[
						self::bar( 80, 178, 4, 240, '#22d3ee' ),
						self::h( '10× Your Productivity', '#f0fdfa', 56, 800, 112, 178, 800, 84, 'h2', 'fade-right', 0.0, 'left' ),
						self::t( 'Automate repetitive tasks and focus on what truly matters — building great products.', '#94a3b8', 19, 400, 112, 278, 720, 70, 'fade-right', 0.15, 'left' ),
						self::btn( 'See How It Works', '#22d3ee', '#020617', 112, 368, 260, 52, 'play', 'fade-right', 0.3 ),
					]
				),
				self::slide(
					'#020617',
					[
						self::h( 'Join 50,000+ Users', '#f0fdfa', 62, 800, 140, 175, 1000, 92, 'h2', 'fade-up', 0.0 ),
						self::bar( 560, 278, 160, 4, '#22d3ee' ),
						self::t( 'Trusted by startups and enterprises in 90+ countries worldwide. No credit card needed.', '#94a3b8', 20, 400, 240, 298, 800, 55, 'fade-up', 0.15 ),
						self::btn( 'Create Account', '#22d3ee', '#020617', 490, 375, 300, 52, 'arrow-right', 'fade-up', 0.3 ),
					]
				),
			]
		);
	}

	private static function tpl_minimal(): array {
		return self::tpl(
			'minimal',
			'Minimal',
			'Three-slide white typographic layout — clean and distraction-free.',
			'minimal',
			[ '#ffffff', '#111827', '#6b7280' ],
			self::sm(),
			[
				self::slide(
					'#ffffff',
					[
						self::bar( 140, 185, 48, 4, '#111827' ),
						self::h( 'Less is More', '#111827', 72, 800, 140, 205, 1000, 108, 'h1', 'fade-up', 0.0 ),
						self::t( 'The simplest solutions are often the most powerful. Start here.', '#6b7280', 21, 400, 240, 328, 800, 55, 'fade', 0.2 ),
					]
				),
				self::slide(
					'#f9fafb',
					[
						self::bar( 140, 185, 48, 4, '#111827' ),
						self::h( 'Clarity Over Complexity', '#111827', 60, 800, 140, 205, 1000, 90, 'h2', 'fade-up', 0.0 ),
						self::t( 'Remove the noise. Keep only what matters. Serve your audience better.', '#6b7280', 21, 400, 240, 310, 800, 55, 'fade', 0.2 ),
						self::btn( 'Explore', '#111827', '#ffffff', 510, 385, 260, 52, 'arrow-right', 'fade-up', 0.3 ),
					]
				),
				self::slide(
					'#ffffff',
					[
						self::bar( 140, 185, 48, 4, '#111827' ),
						self::h( 'Ready to Begin?', '#111827', 72, 800, 140, 205, 1000, 108, 'h2', 'fade-up', 0.0 ),
						self::btn( 'Get Started →', '#111827', '#ffffff', 510, 340, 260, 52, 'none', 'fade-up', 0.2 ),
					]
				),
			]
		);
	}

	private static function tpl_restaurant(): array {
		return self::tpl(
			'restaurant',
			'Restaurant',
			'Warm three-slide restaurant carousel with amber tones.',
			'food',
			[ '#78350f', '#fbbf24', '#fef9c3' ],
			self::sm(),
			[
				self::slide(
					'#78350f',
					[
						self::t( 'ESTABLISHED 2010', '#fbbf24', 11, 600, 140, 162, 1000, 28, 'fade', 0.0 ),
						self::h( 'Authentic Italian Cuisine', '#fef9c3', 58, 700, 140, 195, 1000, 88, 'h1', 'fade-up', 0.05 ),
						self::bar( 560, 295, 160, 4, '#fbbf24' ),
						self::t( 'Fresh ingredients, traditional recipes, unforgettable flavours — every single visit.', '#fde68a', 19, 400, 240, 315, 800, 55, 'fade-up', 0.2 ),
						self::btn( 'Reserve a Table', '#fbbf24', '#78350f', 490, 390, 300, 52, 'arrow-right', 'fade-up', 0.35 ),
					]
				),
				self::slide(
					'#92400e',
					[
						self::img( 40, 50, 540, 500, 'fade-right', 0.0 ),
						self::t( 'TODAY\'S SPECIALS', '#fbbf24', 11, 700, 660, 155, 560, 28, 'fade', 0.0, 'left' ),
						self::h( 'Handcrafted with Love', '#fef9c3', 50, 700, 660, 188, 560, 84, 'h2', 'fade-left', 0.05, 'left' ),
						self::bar( 660, 285, 80, 4, '#fbbf24' ),
						self::t( 'Seasonal ingredients sourced daily from local farms and artisan producers.', '#fde68a', 18, 400, 660, 305, 560, 70, 'fade-left', 0.2, 'left' ),
						self::btn( 'View Menu', '#fbbf24', '#92400e', 660, 395, 220, 52, 'external', 'fade-left', 0.35 ),
					]
				),
				self::slide(
					'#b45309',
					[
						self::h( 'Join Us for Dinner', '#fef9c3', 62, 700, 140, 185, 1000, 92, 'h2', 'fade-up', 0.0 ),
						self::bar( 560, 290, 160, 4, '#fbbf24' ),
						self::t( 'Open Tuesday–Sunday, 5 pm–11 pm. Private dining available for events.', '#fde68a', 19, 400, 240, 310, 800, 55, 'fade-up', 0.15 ),
						self::btn( 'Book Online', '#fbbf24', '#b45309', 510, 385, 260, 52, 'arrow-right', 'fade-up', 0.3 ),
					]
				),
			]
		);
	}

	private static function tpl_charity(): array {
		return self::tpl(
			'charity',
			'Charity / Nonprofit',
			'Two-slide cause-driven slider in teal with donation CTA.',
			'nonprofit',
			[ '#0c4a6e', '#38bdf8', '#f0f9ff' ],
			self::sm(),
			[
				self::slide(
					'#0c4a6e',
					[
						self::img( 680, 50, 540, 500, 'fade', 0.0 ),
						self::h( 'Make a Difference Today', '#f0f9ff', 52, 700, 60, 155, 560, 84, 'h1', 'fade-right', 0.0, 'left' ),
						self::bar( 60, 252, 100, 4, '#38bdf8' ),
						self::t( 'Your support helps us provide education, food and shelter to families in need.', '#bae6fd', 19, 400, 60, 272, 560, 70, 'fade-right', 0.15, 'left' ),
						self::btn( 'Donate Now', '#38bdf8', '#0c4a6e', 60, 362, 220, 52, 'check', 'fade-right', 0.3 ),
					]
				),
				self::slide(
					'#075985',
					[
						self::h( 'Every Dollar Counts', '#f0f9ff', 60, 700, 140, 175, 1000, 88, 'h2', 'fade-up', 0.0 ),
						self::bar( 560, 276, 160, 4, '#38bdf8' ),
						self::t( '92 cents of every dollar donated goes directly to the people who need it most.', '#bae6fd', 20, 400, 240, 296, 800, 55, 'fade-up', 0.15 ),
						self::btn( 'Get Involved', '#38bdf8', '#075985', 510, 373, 260, 52, 'arrow-right', 'fade-up', 0.3 ),
					]
				),
			]
		);
	}

	private static function tpl_welcome(): array {
		return self::tpl(
			'welcome',
			'Welcome',
			'Three-slide welcome carousel in vibrant purple with varied animations.',
			'hero',
			[ '#581c87', '#e879f9', '#fdf4ff' ],
			self::sm(),
			[
				self::slide(
					'#581c87',
					[
						self::h( 'Welcome to [Your Brand]', '#fdf4ff', 58, 700, 140, 175, 1000, 88, 'h1', 'fade-up', 0.0 ),
						self::bar( 560, 276, 160, 4, '#e879f9' ),
						self::t( 'We are so glad you are here. Explore what we have built just for you.', '#e9d5ff', 20, 400, 240, 296, 800, 55, 'fade-up', 0.15 ),
						self::btn( 'Explore Now', '#e879f9', '#581c87', 510, 373, 260, 52, 'arrow-right', 'fade-up', 0.3 ),
					]
				),
				self::slide(
					'#4c1d95',
					[
						self::bar( 80, 175, 4, 250, '#c084fc' ),
						self::h( 'Discover Our Story', '#fdf4ff', 52, 700, 112, 178, 780, 78, 'h2', 'fade-right', 0.0, 'left' ),
						self::t( 'Founded with passion, built with purpose — everything we do starts with you.', '#e9d5ff', 19, 400, 112, 272, 720, 70, 'fade-right', 0.15, 'left' ),
						self::btn( 'Our Mission', '#c084fc', '#4c1d95', 112, 362, 240, 52, 'external', 'fade-right', 0.3 ),
					]
				),
				self::slide(
					'#3b0764',
					[
						self::h( 'Let\'s Get Started', '#fdf4ff', 64, 800, 140, 170, 1000, 96, 'h2', 'zoom-in', 0.0 ),
						self::bar( 560, 278, 160, 4, '#e879f9' ),
						self::t( 'Join thousands of happy users and experience the difference today.', '#e9d5ff', 20, 400, 240, 298, 800, 55, 'fade-up', 0.2 ),
						self::btn( 'Create Account', '#e879f9', '#3b0764', 490, 375, 300, 52, 'arrow-right', 'zoom-in', 0.35 ),
					]
				),
			]
		);
	}

	// ── Slide definitions ─────────────────────────────────────────────────────

	private static function sl_dark_blue(): array {
		return self::sl( 'dark-blue', 'Dark Blue Hero', 'Heading + subtext + button on deep navy.', 'dark',
			self::slide( '#1e3a8a', [
				self::h( 'Your Headline Here', '#ffffff', 60, 700, 140, 175, 1000, 88, 'h1', 'fade-up', 0.0 ),
				self::bar( 560, 276, 160, 4, '#93c5fd' ),
				self::t( 'A clear, concise subheading that supports your main message.', '#bfdbfe', 20, 400, 240, 296, 800, 55, 'fade-up', 0.15 ),
				self::btn( 'Get Started', '#3b82f6', '#ffffff', 510, 373, 260, 52, 'arrow-right', 'fade-up', 0.3 ),
			] )
		);
	}

	private static function sl_red_impact(): array {
		return self::sl( 'red-impact', 'Red Impact', 'Bold heading on deep red with subtext.', 'dark',
			self::slide( '#991b1b', [
				self::h( 'Make an Impact', '#ffffff', 68, 800, 140, 168, 1000, 100, 'h1', 'zoom-in', 0.0 ),
				self::bar( 560, 282, 160, 4, '#fca5a5' ),
				self::t( 'Bold action. Powerful results. Start today and never look back.', '#fecaca', 20, 400, 240, 300, 800, 55, 'fade-up', 0.2 ),
			] )
		);
	}

	private static function sl_clean_white(): array {
		return self::sl( 'clean-white', 'Clean White', 'Minimal heading + subtext on off-white.', 'light',
			self::slide( '#f8fafc', [
				self::bar( 560, 218, 48, 4, '#1e293b' ),
				self::h( 'Clean and Simple', '#1e293b', 60, 800, 140, 240, 1000, 90, 'h1', 'fade-up', 0.0 ),
				self::t( 'Sometimes the most powerful message is the clearest one.', '#64748b', 20, 400, 240, 344, 800, 55, 'fade', 0.2 ),
			] )
		);
	}

	private static function sl_charcoal(): array {
		return self::sl( 'charcoal', 'Charcoal', 'White heading + accent shape on near-black.', 'dark',
			self::slide( '#1c1917', [
				self::bar( 80, 198, 80, 4, '#78716c' ),
				self::h( 'Timeless Design', '#fafaf9', 64, 700, 140, 220, 1000, 96, 'h1', 'fade-up', 0.1 ),
				self::t( 'Crafted with intention. Built to last. Designed to inspire.', '#a8a29e', 20, 400, 240, 328, 800, 55, 'fade', 0.25 ),
			] )
		);
	}

	private static function sl_ocean_blue(): array {
		return self::sl( 'ocean-blue', 'Ocean Blue', 'Heading + subtext + button on ocean blue.', 'dark',
			self::slide( '#0369a1', [
				self::h( 'Dive Deeper', '#ffffff', 64, 700, 140, 170, 1000, 96, 'h1', 'fade-up', 0.0 ),
				self::bar( 560, 278, 160, 4, '#7dd3fc' ),
				self::t( 'Explore what lies beneath the surface. New horizons await.', '#bae6fd', 20, 400, 240, 298, 800, 55, 'fade-up', 0.15 ),
				self::btn( 'Explore', '#0ea5e9', '#ffffff', 510, 373, 260, 52, 'arrow-right', 'fade-up', 0.3 ),
			] )
		);
	}

	private static function sl_sale_red(): array {
		return self::sl( 'sale-red', 'Sale Banner', 'Big SALE heading + discount text + button.', 'promo',
			self::slide( '#b91c1c', [
				self::h( 'SALE', '#ffffff', 110, 900, 140, 120, 1000, 160, 'h1', 'zoom-in', 0.0 ),
				self::h( '50% Off Everything', '#fbbf24', 38, 700, 160, 298, 960, 60, 'h2', 'fade-up', 0.2 ),
				self::t( 'Use code SAVE50 at checkout. This weekend only.', '#fecaca', 18, 400, 240, 372, 800, 48, 'fade', 0.35 ),
				self::btn( 'Shop Now', '#fbbf24', '#b91c1c', 510, 432, 260, 52, 'arrow-right', 'fade-up', 0.45 ),
			] )
		);
	}

	private static function sl_quote_light(): array {
		return self::sl( 'quote-light', 'Quote / Testimonial', 'Customer quote on a light background.', 'content',
			self::slide( '#f1f5f9', [
				self::h( '"', '#3b82f6', 120, 900, 76, 80, 100, 130, 'h2', 'fade', 0.0 ),
				self::h( 'This is the best tool we\'ve ever used. Absolute game-changer.', '#1e293b', 30, 600, 140, 158, 1000, 140, 'h2', 'fade-up', 0.1 ),
				self::bar( 140, 312, 60, 3, '#3b82f6' ),
				self::t( 'Alex Kim — Product Manager, LaunchPad', '#475569', 16, 600, 140, 332, 500, 38, 'fade', 0.25 ),
			] )
		);
	}

	private static function sl_stats_dark(): array {
		return self::sl( 'stats-dark', 'Stats / Numbers', 'Three key statistics on a dark background.', 'content',
			self::slide( '#0f172a', [
				self::h( 'By the Numbers', '#f1f5f9', 42, 700, 140, 115, 1000, 64, 'h2', 'fade-up', 0.0 ),
				self::bar( 560, 190, 160, 3, '#38bdf8' ),
				self::h( '10M+', '#38bdf8', 56, 800, 80, 240, 360, 84, 'h3', 'fade-up', 0.1 ),
				self::t( 'Active Users', '#94a3b8', 16, 500, 80, 332, 360, 36, 'fade', 0.15 ),
				self::h( '99.9%', '#38bdf8', 56, 800, 460, 240, 360, 84, 'h3', 'fade-up', 0.2 ),
				self::t( 'Uptime SLA', '#94a3b8', 16, 500, 460, 332, 360, 36, 'fade', 0.25 ),
				self::h( '4.9★', '#38bdf8', 56, 800, 840, 240, 360, 84, 'h3', 'fade-up', 0.3 ),
				self::t( 'Average Rating', '#94a3b8', 16, 500, 840, 332, 360, 36, 'fade', 0.35 ),
			] )
		);
	}

	private static function sl_cta_green(): array {
		return self::sl( 'cta-green', 'CTA — Green', 'Strong call-to-action on forest green.', 'cta',
			self::slide( '#14532d', [
				self::h( 'Ready to Grow?', '#f0fdf4', 64, 700, 140, 178, 1000, 96, 'h1', 'fade-up', 0.0 ),
				self::bar( 560, 285, 160, 4, '#86efac' ),
				self::t( 'Join thousands of teams already growing their business with us.', '#bbf7d0', 20, 400, 240, 305, 800, 55, 'fade-up', 0.15 ),
				self::btn( 'Start Free Trial', '#16a34a', '#ffffff', 490, 382, 300, 52, 'arrow-right', 'fade-up', 0.3 ),
			] )
		);
	}

	private static function sl_event_dark(): array {
		return self::sl( 'event-dark', 'Event Announcement', 'Date + event name + venue on dark background.', 'event',
			self::slide( '#09090b', [
				self::t( 'JUNE 21, 2025 — LONDON, UK', '#facc15', 12, 700, 140, 160, 1000, 28, 'fade', 0.0 ),
				self::h( 'Global Leaders Summit', '#fafafa', 60, 700, 140, 193, 1000, 88, 'h1', 'fade-up', 0.1 ),
				self::bar( 560, 293, 160, 4, '#facc15' ),
				self::t( 'The world\'s most influential minds in one room. Will you be there?', '#a1a1aa', 19, 400, 240, 313, 800, 55, 'fade-up', 0.2 ),
				self::btn( 'Get Tickets', '#facc15', '#09090b', 510, 390, 260, 52, 'arrow-right', 'fade-up', 0.35 ),
			] )
		);
	}

	private static function sl_product_blue(): array {
		return self::sl( 'product-blue', 'Product Feature', 'Product name + tagline + price on teal-blue.', 'business',
			self::slide( '#0c4a6e', [
				self::t( 'NEW ARRIVAL', '#7dd3fc', 11, 700, 140, 158, 1000, 28, 'fade', 0.0 ),
				self::h( 'Product Name Pro', '#ffffff', 62, 800, 140, 192, 1000, 92, 'h1', 'fade-up', 0.1 ),
				self::bar( 560, 296, 160, 4, '#7dd3fc' ),
				self::t( 'The most advanced solution for modern professionals. Starting at $49/mo.', '#bae6fd', 19, 400, 240, 316, 800, 55, 'fade-up', 0.2 ),
				self::btn( 'Buy Now', '#0ea5e9', '#ffffff', 510, 393, 260, 52, 'cart', 'fade-up', 0.35 ),
			] )
		);
	}

	private static function sl_team_light(): array {
		return self::sl( 'team-light', 'Team Member', 'Name + role + bio on light background.', 'team',
			self::slide( '#f8fafc', [
				self::t( 'MEET THE TEAM', '#6366f1', 11, 700, 80, 155, 400, 28, 'fade', 0.0 ),
				self::h( 'Jordan Taylor', '#111827', 60, 700, 80, 188, 700, 90, 'h2', 'fade-up', 0.1 ),
				self::bar( 80, 290, 80, 3, '#6366f1' ),
				self::t( 'Chief Technology Officer', '#374151', 20, 600, 80, 308, 600, 40, 'fade-up', 0.2 ),
				self::t( '"I believe great software is built at the intersection of empathy, precision and bold ideas."', '#6b7280', 18, 400, 80, 362, 660, 90, 'fade-up', 0.3 ),
			] )
		);
	}

	private static function sl_nature(): array {
		return self::sl( 'nature', 'Nature / Green', 'Heading + button on deep green.', 'dark',
			self::slide( '#14532d', [
				self::h( 'Connect with Nature', '#f0fdf4', 60, 700, 140, 185, 1000, 90, 'h1', 'fade-up', 0.0 ),
				self::bar( 560, 287, 160, 4, '#4ade80' ),
				self::t( 'Sustainable choices for a healthier planet and a better future for all.', '#bbf7d0', 20, 400, 240, 307, 800, 55, 'fade-up', 0.15 ),
				self::btn( 'Learn More', '#16a34a', '#ffffff', 510, 384, 260, 52, 'arrow-right', 'fade-up', 0.3 ),
			] )
		);
	}

	private static function sl_purple_creative(): array {
		return self::sl( 'purple-creative', 'Purple Creative', 'Bold heading + tagline on deep purple.', 'dark',
			self::slide( '#4c1d95', [
				self::h( 'Creativity Has No Limits', '#fdf4ff', 58, 800, 140, 178, 1000, 88, 'h1', 'fade-up', 0.0 ),
				self::bar( 560, 278, 160, 4, '#c084fc' ),
				self::t( 'Break conventions. Challenge assumptions. Build the impossible.', '#e9d5ff', 20, 400, 240, 298, 800, 55, 'fade-up', 0.15 ),
				self::btn( 'Start Creating', '#9333ea', '#ffffff', 510, 375, 260, 52, 'plus', 'fade-up', 0.3 ),
			] )
		);
	}

	private static function sl_warm_amber(): array {
		return self::sl( 'warm-amber', 'Warm Amber', 'Heading + tagline + button on warm brown.', 'dark',
			self::slide( '#92400e', [
				self::h( 'Warm and Welcoming', '#fef9c3', 60, 700, 140, 178, 1000, 90, 'h1', 'fade-up', 0.0 ),
				self::bar( 560, 280, 160, 4, '#fbbf24' ),
				self::t( 'A cosy experience crafted with care, warmth and attention to every detail.', '#fde68a', 20, 400, 240, 300, 800, 55, 'fade-up', 0.15 ),
				self::btn( 'Discover More', '#fbbf24', '#92400e', 490, 377, 300, 52, 'arrow-right', 'fade-up', 0.3 ),
			] )
		);
	}

	private static function sl_thank_you(): array {
		return self::sl( 'thank-you', 'Thank You', 'Thank you slide on deep navy — great as the last slide.', 'content',
			self::slide( '#1e3a8a', [
				self::h( 'Thank You!', '#ffffff', 72, 800, 140, 185, 1000, 108, 'h1', 'fade-up', 0.0 ),
				self::bar( 560, 305, 160, 4, '#93c5fd' ),
				self::t( 'We appreciate your time. Feel free to reach out with any questions.', '#bfdbfe', 20, 400, 240, 325, 800, 55, 'fade', 0.2 ),
				self::btn( 'Contact Us', '#3b82f6', '#ffffff', 510, 400, 260, 52, 'mail', 'fade-up', 0.35 ),
			] )
		);
	}

	private static function sl_minimal_text(): array {
		return self::sl( 'minimal-text', 'Minimal Typography', 'Single bold centered heading — nothing more.', 'minimal',
			self::slide( '#fafafa', [
				self::bar( 560, 248, 48, 4, '#111827' ),
				self::h( 'One Clear Message', '#111827', 72, 800, 140, 272, 1000, 108, 'h1', 'fade-up', 0.0 ),
			] )
		);
	}

	private static function sl_two_column(): array {
		return self::sl( 'two-column', 'Two Column', 'Left heading + right description text on slate.', 'content',
			self::slide( '#1e293b', [
				self::bar( 80, 198, 4, 200, '#38bdf8' ),
				self::h( 'Our Story', '#f1f5f9', 52, 700, 112, 195, 480, 208, 'h2', 'fade-right', 0.0 ),
				self::t( 'Founded in 2018, we set out to solve a problem that every growing team faces. Today we serve over a million users across 80 countries with a product that just works.', '#94a3b8', 18, 400, 640, 198, 560, 180, 'fade-left', 0.1 ),
			] )
		);
	}

	private static function sl_launch(): array {
		return self::sl( 'launch', 'Coming Soon / Launch', 'Teaser slide with notify button on purple.', 'promo',
			self::slide( '#581c87', [
				self::t( 'SOMETHING BIG IS COMING', '#e879f9', 11, 700, 140, 158, 1000, 28, 'fade', 0.0 ),
				self::h( 'Coming Soon', '#fdf4ff', 72, 800, 140, 193, 1000, 108, 'h1', 'fade-up', 0.1 ),
				self::bar( 560, 312, 160, 4, '#e879f9' ),
				self::t( 'We are working on something you will love. Be the first to know when we launch.', '#e9d5ff', 19, 400, 240, 332, 800, 55, 'fade-up', 0.2 ),
				self::btn( 'Notify Me', '#9333ea', '#ffffff', 510, 410, 260, 52, 'mail', 'fade-up', 0.35 ),
			] )
		);
	}

	private static function sl_feature_list(): array {
		return self::sl( 'feature-list', 'Feature List', 'Heading + three bullet-point features on dark.', 'content',
			self::slide( '#0f172a', [
				self::h( 'Everything You Need', '#f1f5f9', 48, 700, 140, 120, 1000, 72, 'h2', 'fade-up', 0.0 ),
				self::bar( 560, 204, 160, 3, '#38bdf8' ),
				self::t( '→  Drag-and-drop visual editor — no code required', '#94a3b8', 19, 400, 140, 230, 1000, 44, 'fade-up', 0.1 ),
				self::t( '→  Responsive layouts for every device and screen size', '#94a3b8', 19, 400, 140, 282, 1000, 44, 'fade-up', 0.2 ),
				self::t( '→  One-click publish and embed anywhere on your site', '#94a3b8', 19, 400, 140, 334, 1000, 44, 'fade-up', 0.3 ),
				self::btn( 'See All Features', '#38bdf8', '#0f172a', 490, 410, 300, 52, 'arrow-right', 'fade-up', 0.45 ),
			] )
		);
	}

	// ── Low-level builders ────────────────────────────────────────────────────

	private static function tpl( string $id, string $name, string $desc, string $cat, array $colors, array $settings, array $slides ): array {
		return [
			'id'             => $id,
			'name'           => $name,
			'description'    => $desc,
			'category'       => $cat,
			'preview_colors' => $colors,
			'data'           => [
				'version'  => 1,
				'settings' => $settings,
				'slides'   => $slides,
			],
		];
	}

	private static function sl( string $id, string $name, string $desc, string $cat, array $slide_data ): array {
		return [
			'id'          => $id,
			'name'        => $name,
			'description' => $desc,
			'category'    => $cat,
			'slide_data'  => $slide_data,
		];
	}

	private static function slide( string $bg, array $layers = [] ): array {
		return [
			'id'             => '',
			'type'           => 'image',
			'image_id'       => 0,
			'image_alt'      => '',
			'image_title'    => '',
			'alt_source'     => 'media',
			'title_source'   => 'media',
			'bg_fit'         => 'cover',
			'bg_size_x'      => 100,
			'bg_size_y'      => 100,
			'bg_repeat'      => 'no-repeat',
			'bg_position'    => 'middle-center',
			'bg_position_x'  => 50,
			'bg_position_y'  => 50,
			'video_id'       => 0,
			'bg_color'       => $bg,
			'heading'        => '',
			'content'        => '',
			'link_url'       => '',
			'link_target'    => '_self',
			'layers'         => $layers,
		];
	}

	/** Heading layer. */
	private static function h( string $text, string $color, int $size, int $weight, int $x, int $y, int $w, int $h, string $tag = 'h2', string $anim = 'fade-up', float $delay = 0.0, string $align = 'center' ): array {
		return self::make_layer( 'heading', $text, $color, 'transparent', $size, $weight, $align, 0, 0, $x, $y, $w, $h, $tag, 'none', 'right', $anim, $delay, 1.2 );
	}

	/** Text / paragraph layer. */
	private static function t( string $text, string $color, int $size, int $weight, int $x, int $y, int $w, int $h, string $anim = 'fade-up', float $delay = 0.0, string $align = 'center' ): array {
		return self::make_layer( 'text', $text, $color, 'transparent', $size, $weight, $align, 0, 0, $x, $y, $w, $h, 'p', 'none', 'right', $anim, $delay, 1.5 );
	}

	/** Button layer. */
	private static function btn( string $text, string $bg, string $color, int $x, int $y, int $w, int $h, string $icon = 'arrow-right', string $anim = 'fade-up', float $delay = 0.0 ): array {
		return self::make_layer( 'button', $text, $color, $bg, 16, 600, 'center', 14, 6, $x, $y, $w, $h, 'p', $icon, 'right', $anim, $delay, 1.4 );
	}

	/** Image placeholder layer — set the actual image in the editor. Hidden on mobile. */
	private static function img( int $x, int $y, int $w, int $h, string $anim = 'fade', float $delay = 0.0 ): array {
		return [
			'id'        => '',
			'name'      => 'Image',
			'type'      => 'image',
			'position'  => [ 'x' => $x, 'y' => $y ],
			'size'      => [ 'width' => $w, 'height' => $h ],
			'rotation'  => 0,
			'z_index'   => 0,
			'content'   => [
				'text'          => '',
				'image_id'      => 0,
				'href'          => '',
				'target'        => '_self',
				'icon'          => 'none',
				'icon_position' => 'right',
				'video_url'     => '',
				'tag'           => 'div',
			],
			'style'     => [
				'color'            => '#ffffff',
				'background'       => '#334155',
				'font_family'      => '',
				'font_size'        => 16,
				'font_weight'      => 400,
				'text_align'       => 'center',
				'padding'          => 0,
				'border_radius'    => 8,
				'line_height'      => 1.5,
				'letter_spacing'   => 0,
				'hover_color'      => '',
				'hover_background' => '',
			],
			'animation' => [
				'in'  => [ 'preset' => $anim, 'x' => 0, 'y' => 0, 'opacity' => 0, 'scale' => 1, 'rotation' => 0, 'duration' => 0.6, 'delay' => $delay, 'ease' => 'ease-out' ],
				'out' => [ 'preset' => 'none', 'x' => 0, 'y' => 0, 'opacity' => 1, 'scale' => 1, 'rotation' => 0, 'duration' => 0.4, 'delay' => 0.0, 'ease' => 'ease-in' ],
			],
			'timing'     => [ 'start' => 0.0, 'end' => null ],
			'responsive' => [
				'tablet' => [ 'position' => null, 'size' => null, 'style' => null, 'hidden' => null ],
				'mobile' => [ 'position' => null, 'size' => null, 'style' => null, 'hidden' => true ],
			],
			'hidden' => false,
		];
	}

	/** Shape / accent bar layer. */
	private static function bar( int $x, int $y, int $w, int $h, string $bg, int $radius = 2 ): array {
		return [
			'id'        => '',
			'name'      => 'Accent',
			'type'      => 'shape',
			'position'  => [ 'x' => $x, 'y' => $y ],
			'size'      => [ 'width' => $w, 'height' => $h ],
			'rotation'  => 0,
			'z_index'   => 1,
			'content'   => [],
			'style'     => [
				'color'            => '#ffffff',
				'background'       => $bg,
				'font_family'      => '',
				'font_size'        => 16,
				'font_weight'      => 400,
				'text_align'       => 'left',
				'padding'          => 0,
				'border_radius'    => $radius,
				'line_height'      => 1.5,
				'letter_spacing'   => 0,
				'hover_color'      => '',
				'hover_background' => '',
			],
			'animation' => [
				'in'  => [ 'preset' => 'fade', 'x' => 0, 'y' => 0, 'opacity' => 0, 'scale' => 1, 'rotation' => 0, 'duration' => 0.4, 'delay' => 0.0, 'ease' => 'ease-out' ],
				'out' => [ 'preset' => 'none', 'x' => 0, 'y' => 0, 'opacity' => 1, 'scale' => 1, 'rotation' => 0, 'duration' => 0.4, 'delay' => 0.0, 'ease' => 'ease-in' ],
			],
			'timing'     => [ 'start' => 0.0, 'end' => null ],
			'responsive' => [
				'tablet' => [ 'position' => null, 'size' => null, 'style' => null, 'hidden' => null ],
				'mobile' => [ 'position' => null, 'size' => null, 'style' => null, 'hidden' => null ],
			],
			'hidden' => false,
		];
	}

	private static function make_layer(
		string $type, string $text, string $color, string $bg,
		int $size, int $weight, string $align, int $padding, int $radius,
		int $x, int $y, int $w, int $h,
		string $tag, string $icon, string $icon_pos,
		string $anim, float $delay, float $line_height
	): array {
		return [
			'id'        => '',
			'name'      => ucfirst( $type ),
			'type'      => $type,
			'position'  => [ 'x' => $x, 'y' => $y ],
			'size'      => [ 'width' => $w, 'height' => $h ],
			'rotation'  => 0,
			'z_index'   => 0,
			'content'   => [
				'text'          => $text,
				'image_id'      => 0,
				'href'          => 'button' === $type ? '#' : '',
				'target'        => '_self',
				'icon'          => 'button' === $type ? $icon : 'none',
				'icon_position' => $icon_pos,
				'video_url'     => '',
				'tag'           => $tag,
			],
			'style'     => [
				'color'            => $color,
				'background'       => $bg,
				'font_family'      => '',
				'font_size'        => $size,
				'font_weight'      => $weight,
				'text_align'       => $align,
				'padding'          => $padding,
				'border_radius'    => $radius,
				'line_height'      => $line_height,
				'letter_spacing'   => 0,
				'hover_color'      => '',
				'hover_background' => '',
			],
			'animation' => [
				'in'  => [ 'preset' => $anim, 'x' => 0, 'y' => 0, 'opacity' => 0, 'scale' => 1, 'rotation' => 0, 'duration' => 0.6, 'delay' => $delay, 'ease' => 'ease-out' ],
				'out' => [ 'preset' => 'none', 'x' => 0, 'y' => 0, 'opacity' => 1, 'scale' => 1, 'rotation' => 0, 'duration' => 0.4, 'delay' => 0.0, 'ease' => 'ease-in' ],
			],
			'timing'     => [ 'start' => 0.0, 'end' => null ],
			'responsive' => [
				'tablet' => [ 'position' => null, 'size' => null, 'style' => null, 'hidden' => null ],
				'mobile' => [ 'position' => null, 'size' => null, 'style' => null, 'hidden' => null ],
			],
			'hidden' => false,
		];
	}

	// ── Settings presets ──────────────────────────────────────────────────────

	/** Settings for a single-slide hero (no nav/pagination). */
	private static function s1(): array {
		return self::settings( [
			'effect'      => 'fade',
			'navigation'  => false,
			'pagination'  => false,
			'loop'        => false,
			'autoplay'    => false,
		] );
	}

	/** Settings for a multi-slide carousel with nav + pagination + autoplay. */
	private static function sm(): array {
		return self::settings( [
			'effect'               => 'slide',
			'navigation'           => true,
			'pagination'           => true,
			'loop'                 => true,
			'autoplay'             => true,
			'autoplay_delay'       => 5000,
			'autoplay_pause_on_hover' => true,
		] );
	}

	private static function settings( array $override = [] ): array {
		return array_merge(
			[
				'canvas_width'            => 1280,
				'canvas_height'           => 600,
				'effect'                  => 'slide',
				'direction'               => 'horizontal',
				'navigation'              => false,
				'nav_placement'           => 'inside',
				'nav_position'            => 'middle',
				'nav_color'               => '#ffffff',
				'nav_size'                => 44,
				'nav_offset'              => 12,
				'pagination'              => false,
				'pagination_type'         => 'bullets',
				'pagination_placement'    => 'inside',
				'pagination_position'     => 'bottom',
				'pagination_color'        => '#ffffff',
				'pagination_offset'       => 16,
				'pagination_bullet_size'  => 8,
				'pagination_bullet_gap'   => 6,
				'pagination_clickable'    => true,
				'autoplay'                => false,
				'autoplay_delay'          => 5000,
				'autoplay_pause_on_hover' => true,
				'loop'                    => false,
				'speed'                   => 600,
				'lazy_load'               => true,
				'full_screen'             => false,
				'scrollbar'               => false,
				'thumbnails'              => false,
				'thumbnails_height'       => 80,
				'thumbnails_gap'          => 8,
				'bg_animation'            => 'none',
				'canvas_responsive'       => [
					'tablet' => [ 'width' => 768, 'height' => 450 ],
					'mobile' => [ 'width' => 390, 'height' => 300 ],
				],
			],
			$override
		);
	}
}
