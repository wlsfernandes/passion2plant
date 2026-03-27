<div class="card border mb-4">

    <div class="card-header bg-light fw-semibold">
        Features
    </div>

    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Feature Type</label>

            <select name="feature_type" class="form-control" required>
                <option value="">Select Feature</option>
                <option value="blog"
                    {{ old('feature_type', $section->feature_type ?? '') == 'blog' ? 'selected' : '' }}>Blog
                </option>
                <option value="contact"
                    {{ old('feature_type', $section->feature_type ?? '') == 'contact' ? 'selected' : '' }}>Contact
                </option>

                <option value="event"
                    {{ old('feature_type', $section->feature_type ?? '') == 'event' ? 'selected' : '' }}>Event
                </option>
                <option value="resource"
                    {{ old('feature_type', $section->feature_type ?? '') == 'resource' ? 'selected' : '' }}>Resource
                </option>
                <option value="service"
                    {{ old('feature_type', $section->feature_type ?? '') == 'service' ? 'selected' : '' }}>Service
                </option>
                <option value="position"
                    {{ old('feature_type', $section->feature_type ?? '') == 'position' ? 'selected' : '' }}>Position
                </option>
                <option value="team"
                    {{ old('feature_type', $section->feature_type ?? '') == 'team' ? 'selected' : '' }}>Team
                </option>
            </select>
        </div>
        <p class="text-muted">
            A <strong>Feature</strong> section displays dynamic content from your platform in a visually engaging way,
            such as s or highlighted blocks. For example, you can showcase recent blog posts, team members,
            testimonials, services, events, or contact information. Instead of adding content manually, this section
            automatically pulls and
            displays the latest items, keeping your page fresh and interactive.
        </p>
    </div>
</div>
