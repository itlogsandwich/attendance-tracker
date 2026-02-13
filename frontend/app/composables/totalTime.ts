import type { Project } from "#shared/types/project";
import type { TimeEntry } from "#shared/types/time-entry";

export const totalTime = (entries: TimeEntry[], projects: Project[]): string => {
  if (!entries || !projects) return "0:00:0";

  let total_seconds: number = 0;

  for (var project of projects) {
    const project_entries = entries.filter(entry => entry.project_id === project.id);
    for (var entry of project_entries) {
      total_seconds += entry.total_seconds;
    }
  }

  return formatDuration(total_seconds);
}
