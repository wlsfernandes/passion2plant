<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Carousel
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Carousel</label>

            <select name="carousel_type" class="form-control" required>
                <option value="">Select carousel</option>

                <option value="team"
                    {{ old('carousel_type', $section->carousel_type ?? '') == 'team' ? 'selected' : '' }}>Team Carousel
                </option>

                <option value="partners"
                    {{ old('carousel_type', $section->carousel_type ?? '') == 'partners' ? 'selected' : '' }}>Partners
                    Carousel
                </option>
                <option value="educators"
                    {{ old('carousel_type', $section->carousel_type ?? '') == 'educators' ? 'selected' : '' }}>Educators
                    Carousel
                </option>
                <option value="testimonial"
                    {{ old('carousel_type', $section->carousel_type ?? '') == 'testimonial' ? 'selected' : '' }}>
                    Testimonial Carousel</option>

                <option value="services"
                    {{ old('carousel_type', $section->carousel_type ?? '') == 'services' ? 'selected' : '' }}>Services
                    Carousel</option>

                <option value="blog"
                    {{ old('carousel_type', $section->carousel_type ?? '') == 'blog' ? 'selected' : '' }}>Blog Carousel
                </option>

                <option value="donate"
                    {{ old('carousel_type', $section->carousel_type ?? '') == 'donate' ? 'selected' : '' }}>Donate
                    Carousel</option>

                <option value="membership"
                    {{ old('carousel_type', $section->carousel_type ?? '') == 'membership' ? 'selected' : '' }}>
                    Membership
                    Carousel</option>

                <option value="event"
                    {{ old('carousel_type', $section->carousel_type ?? '') == 'event' ? 'selected' : '' }}>Event
                    Carousel
                </option>

            </select>
        </div>
        <p class="text-muted">
            A <strong>carousel</strong> section displays dynamic content from your platform in a visually engaging way,
            such as carousels or highlighted blocks. For example, you can showcase recent blog posts, team members,
            testimonials, services, events, or contact information. Instead of adding content manually, this section
            automatically pulls and
            displays the latest items, keeping your page fresh and interactive.
        </p>
    </div>
</div>
