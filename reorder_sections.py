#!/usr/bin/env python3
"""
Script to reorder sections in index.html
Moves "Featured Episodes" (Videos) before "Heroes"
"""

def reorder_sections(input_file, output_file):
    with open(input_file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Find the sections
    heroes_start = content.find('<!-- Heroes Section -->')
    videos_start = content.find('<!-- Videos Section -->')
    
    # Find the end of each section (start of next section or blog section)
    # Heroes section ends where Videos section starts
    heroes_end = videos_start
    
    # Videos section ends where Blog section starts
    blog_start = content.find('<!-- Blog Section -->')
    videos_end = blog_start
    
    # Extract sections
    before_heroes = content[:heroes_start]
    heroes_section = content[heroes_start:heroes_end]
    videos_section = content[videos_start:videos_end]
    after_videos = content[videos_end:]
    
    # Reassemble with videos before heroes
    new_content = before_heroes + videos_section + '\n' + heroes_section + after_videos
    
    # Write to output
    with open(output_file, 'w', encoding='utf-8') as f:
        f.write(new_content)
    
    print(f"✓ Sections reordered successfully")
    print(f"  - 'Featured Episodes' now comes before 'Heroes'")

if __name__ == '__main__':
    reorder_sections('index.html', 'index.html')
